<?php
namespace extas\interfaces\options;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;

/**
 * Interface ICommandOption
 *
 * @package extas\interfaces\options
 * @author jeyroik@gmail.com
 */
interface ICommandOption extends IItem, IHasName, IHasDescription
{
    public const SUBJECT = 'extas.command.option';

    public const FIELD__SHORTCUT = 'shortcut';
    public const FIELD__DEFAULT = 'default';
    public const FIELD__MODE = 'mode';
    public const FIELD__COMMANDS_NAMES = 'commands';

    /**
     * @return array
     */
    public function __toInputOption(): array;

    /**
     * @return string
     */
    public function getShortcut(): string;

    /**
     * @return string
     */
    public function getDefault(): string;

    /**
     * @return int
     */
    public function getMode(): int;

    /**
     * @return array
     */
    public function getCommandsNames(): array;
}
