<?php

/*
 * Copyright (c) 2022.
 * Autor: misspo
 * Site: misspo.ru
 * Phone: +7 (919) 48-10-550
 * E-mail: misspo.ru@gmail.com
 */

class Page extends Site
{
    public string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}