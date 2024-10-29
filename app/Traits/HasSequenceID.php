<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasSequenceID
{
    protected ?int $sequence = null;
    private bool $updatedSequence = false;

    public function setSequence(): self
    {
        $table = $this->getTable();
        $query = "select setval('{$table}_id_seq', (SELECT MAX(id) from {$table}))";
        $this->sequence = DB::selectOne($query)->setval;
        $this->updatedSequence = true;
        return $this;
    }

    public function getSequence(): ?int
    {
        if (! $this->updatedSequence) {
            $this->setSequence();
        }
        return $this->sequence;
    }

    public static function updateSequence(): self
    {
        return (new static())->setSequence();
    }

    public static function getCurrentSequence(): ?int
    {
        return (new static())->getSequence();
    }
}
