<?php


namespace App\Modules\Shared\Mechanism;


use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;

class ModuleTranslator extends Translator
{
    public function __construct(Loader $loader)
    {
        parent::__construct($loader, Config::get('app.locale'));
    }

    public function translate(string $namespace, string $group, string $item): string
    {
        return $this->get("$namespace::$group.$item");
    }
}