<?php
namespace extas\components\plugins\install;

use extas\components\options\CommandOption;

/**
 * Class UninstallCommandsOptions
 *
 * @package extas\components\plugins\install
 * @author jeyroik <jeyroik@gmail.com>
 */
class UninstallCommandsOptions extends InstallSection
{
    protected string $selfSection = 'commands_options';
    protected string $selfName = 'command option';
    protected string $selfRepositoryClass = 'commandOptionRepository';
    protected string $selfUID = CommandOption::FIELD__NAME;
    protected string $selfItemClass = CommandOption::class;
}
