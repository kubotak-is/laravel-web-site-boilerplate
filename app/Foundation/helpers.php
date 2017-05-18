<?php

if (!function_exists('asset_path')) {
    /**
     * マニフェストファイルからアセットパス取得
     * @param string $path
     * @return string
     * @throws Exception
     */
    function asset_path(string $path): string
    {
        $manifest = null;
        static $manifest;
        if (!$manifest) {
            if (!file_exists($manifestPath = public_path('js/manifest.json'))) {
                return $path;
            }
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }
        // 先頭スラッシュ補完
        if (!starts_with($path, '/')) {
            $path = "/{$path}";
        }
        if (!array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unable to locate asset file: {$path}. Please check your ".
                'webpack.config.js output paths and try again.'
            );
        }
        // webpack dev serverから取得
        if (app()->environment() === 'local') {
            $host = request()->getHttpHost();
            return "//{$host}{$manifest[$path]}";
        }
        return $manifest[$path];
    }
}