<?php
namespace extas\components\options;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\interfaces\options\IOption;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Option
 *
 * @package extas\components\options
 * @author jeyroik@gmail.com
 */
class Option extends Item implements IOption
{
    use THasName;
    use THasDescription;

    /**
     * @return array
     */
    public function __toInputOption(): array
    {
        return [
            $this->getName(),
            $this->getShortcut(),
            $this->getMode(),
            $this->getDescription(),
            $this->getDefault()
        ];
    }

    /**
     * @return string
     */
    public function getShortcut(): string
    {
        return $this->config[static::FIELD__SHORTCUT] ?? '';
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->config[static::FIELD__MODE] ?? InputOption::VALUE_OPTIONAL;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->config[static::FIELD__DEFAULT] ?? '';
    }

    /**
     * @return array
     */
    public function getCommandsNames(): array
    {
        return $this->config[static::FIELD__COMMANDS_NAMES] ?? [];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
