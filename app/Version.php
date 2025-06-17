<?php
namespace App;

use Carbon\Carbon;

class Version
{
    public readonly ?string $commit;

    public readonly ?string $commit_short;

    public readonly ?string $tag;

    public readonly ?Carbon $date;

    protected static array $instances = [];

    public function __construct(?string $commit = null, ?string $tag = null, ?Carbon $date = null)
    {
        $this->commit = $commit ?? static::getCurrentGitCommitHash();
        $this->commit_short = substr($this->commit, 0, 7);
        $this->tag = $this->tag();
        $this->date = $this->date();
    }

    public static function make(?string $commit = null, ?string $tag = null, ?Carbon $date = null): self
    {
        if(! isset(static::$instances[$commit])) {
            static::$instances[$commit] = new static($commit);
        }

        return static::$instances[$commit];
    }

    public function toArray(): array
    {
        return [
            'commit' => $this->commit,
            'commit_short' => $this->commit_short,
            'tag' => $this->tag,
            'label' => $this->label(),
            'date' => $this->date,
        ];
    }

    protected function hasTag(): bool
    {
        return $this->tag !== null;
    }

    protected function label(): string
    {
        if(! $this->hasTag()) {
            return $this->commit_short;
        }

        return str_starts_with($this->tag, 'v')
            ? "{$this->tag} ({$this->commit_short})"
            : "v{$this->tag} ({$this->commit_short})";
    }

    protected static function getCurrentGitCommitHash(): ?string
    {
        $path = base_path('.git/');

        if (! file_exists($path)) {
            return null;
        }

        $head = trim(substr(file_get_contents($path . 'HEAD'), 4));

        $hash = trim(file_get_contents(sprintf($path . $head)));

        return $hash;
    }

    protected function tag(): ?string
    {
        $tag = exec('git tag --contains ' . $this->commit);

        return $tag === '' ? null : $tag;
    }

    public function date(): ?Carbon
    {
        $date = exec('git show -s --format=%ci ' . $this->commit);

        return $date === '' ? null : Carbon::parse($date);
    }
}
