# stechstudio/publish-s3-assets

Publishing your assets to S3 has never been easier![^1]

Three steps:

1. Set your desired bucket URL as your `ASSET_URL`
2. Add `ASSET_AWS_BUCKET` to your .env, pointed at the bucket you want to publish your assets to.
3. Run `php artisan assets:publish`.

If you just wanted to publish everything in `public`, you're done!

## But what if I want...

### To publish specific folders?

Pass them as a comma-separated list to `assets:publish`, like so:

```
php artisan assets:publish public/build/assets,public/vendor,public/css/filament,public/js/filament
```

That will publish only what's found in those folders, recursively.

### To remove `public` from the beginning of each asset?

Pass the `--strip-public` option to remove it from the paths. With that, `public/build/assets` locally becomes `build/assets` in your bucket, and so on.

### To remove any files that don't exist?

That's the `--clean` option. It gets all of your destinations (such as `public/build/assets`), then deletes them and their contents before uploading the new files.


[^1]: Neither benchmarked nor proven.
