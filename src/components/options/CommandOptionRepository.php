<?php
namespace extas\components\options;

use extas\components\repositories\Repository;
use extas\interfaces\options\ICommandOptionRepository;

/**
 * Class OptionRepository
 *
 * @package extas\components\options
 * @author jeyroik <jeyroik@gmail.com>
 */
class CommandOptionRepository extends Repository implements ICommandOptionRepository
{
    protected string $name = 'commands_options';
    protected string $scope = 'extas';
    protected string $pk = CommandOption::FIELD__NAME;
    protected string $itemClass = CommandOption::class;
}
