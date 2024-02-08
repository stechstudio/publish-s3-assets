<?php

namespace Stechstudio\PublishS3Assets\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PublishS3AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:publish {folders? : Comma separated list of "sourcefolder:destpath" to recursively publish. Default: public}
                                            {--strip-public : Strip the "public" folder from the destination path}
                                            {--clean : Remove files from destination folders that are not in the source}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish assets to an S3 bucket.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('asset-publish-disk');

        if ($this->option('clean')) {
            $this->getDestinations()
                ->each(function ($destination) use ($disk) {
                    $this->info("Cleaning: $destination");
                    collect($disk->allFiles($destination))->each(fn ($file) => $disk->delete($file));
                    $disk->deleteDirectory($destination);
                });
        }

        $this->getFileList()
            ->each(function ($destination, $source) use ($disk) {

                if ($disk->has($destination)) {
                    $this->info("Updating: $destination");
                    $disk->delete($destination);
                } else {
                    $this->info("Creating: $destination");
                }

                $disk->put(
                    $destination,
                    file_get_contents(base_path($source)),
                );
            });
    }

    private function getDestinations(): Collection
    {
        return collect(explode(',', $this->argument('folders') ?? 'public'))
            ->map(fn ($folder) => $this->getDestination($folder));
    }

    private function getFileList(): Collection
    {
        return collect(explode(',', $this->argument('folders') ?? 'public'))
            ->flatMap(function ($folder) {
                $source = $this->getSource($folder);
                $destination = $this->getDestination($folder);

                return $this->getFiles($source, $destination);
            });
    }

    private function getFiles($source, $destination)
    {
        if (is_file(base_path($source))) {
            return [$source => $destination];
        }

        return collect(
            Storage::build([
                'driver' => 'local',
                'root' => base_path($source),
            ])->allFiles()
        )->mapWithKeys(fn ($file) => [
            $source . '/' . $file => $destination . '/' . $file,
        ])->toArray();
    }

    private function getSource($folder)
    {
        return explode(':', $folder)[0];
    }

    private function getDestination($folder)
    {
        $parts = explode(':', $folder);
        $destination = $parts[1] ?? $parts[0];

        if ($this->option('strip-public') && str_starts_with($destination, 'public/')) {
            $destination = str_replace('public/', '', $destination);
        }

        return $destination;
    }
}
