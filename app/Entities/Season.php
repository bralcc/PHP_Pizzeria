<?php
declare(strict_types= 1);
//season.php

namespace Entities;

class Season {
    private int $id;
    private string $name;
    private string $start_date;
    private string $end_date;

    public function __construct(int $id = 0, string $name = '', string $start_date = '', string $end_date = '') {
        $this->id = $id;
        $this->name = $name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getStartDate(): string {
        return $this->start_date;
    }

    public function setStartDate(string $start_date): void {
        $this->start_date = $start_date;
    }

    public function getEndDate(): string {
        return $this->end_date;
    }

    public function setEndDate(string $end_date): void {
        $this->end_date = $end_date;
    }
}
