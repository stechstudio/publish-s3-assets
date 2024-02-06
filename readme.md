# stechstudio/publish-s3-assets

Publishing your assets to S3 has never been easier![^1]

Four steps:

1. `composer require stechstudio/publish-s3-assets`
2. Set your desired bucket URL as your `ASSET_URL`
3. Add `ASSET_AWS_DEFAULT_REGION` (defaults to `AWS_DEFAULT_REGION`) and `ASSET_AWS_BUCKET` to your .env, pointed at the bucket you want to publish your assets to.
4. Run `php artisan assets:publish`.

If you just wanted to publish everything in `public`, you're done!

## But what if I want...

### ... to publish specific folders?

Pass them as a comma-separated list to `assets:publish`, like so:

```
php artisan assets:publish public/build/assets,public/vendor,public/css/filament,public/js/filament
```

That will publish only what's found in those folders, recursively.

### ... to remove `public` from the beginning of each asset?

```
php artisan assets:publish --strip-public
```

With that, `public/build/assets` locally becomes `build/assets` in your bucket, and so on.

### ... to remove any files that don't exist?

```
php artisan assets:publish --clean
```

It gets all of your destinations (such as `public/build/assets`), then deletes them and their contents before uploading the new files.

[^1]: Claim neither benchmarked nor proven, but we like it!
