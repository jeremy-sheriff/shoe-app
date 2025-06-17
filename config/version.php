<?php

$version = \App\Version::make();

return [
    ...$version->toArray(),
//    'changelog' => "https://github.com/<project>/<name>/releases/tag/{$version->tag}",
    'changelog' => "https://github.com/jeremy-sheriff/shoe-app/tags/{$version->tag}",
];

/**
 * Example output:
 *
 * "commit" => "21c08ad0accb6607f8f347be972640c5a6c99aed"
 * "commit_short" => "21c08ad"
 * "tag" => "v0.1.0-beta"
 * "label" => "v0.1.0-beta (21c08ad)"
 * "date" => <Carbon> "2024-06-23 14:00:00"
 * "changelog" => "https://github.com/project/name/releases/tag/v0.1.0-beta"
 */
