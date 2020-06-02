<?php
namespace extas\components\options;

use extas\interfaces\options\IOption;
use extas\interfaces\repositories\IRepository;

/**
 * Trait TConfigure
 *
 * @method IRepository optionRepository()
 * @method addOption(string $name, string $shortcut, int $mode, string $description, $default)
 *
 * @package extas\components\options
 * @author jeyroik <jeyroik@gmail.com>
 */
trait TConfigure
{
    /**
     * @param string $commandName
     * @param array $reserved
     * @return $this
     */
    protected function configureWithOptions(string $commandName, array $reserved)
    {
        /**
         * @var $options IOption[]
         */
        $repo = $this->optionRepository();
        $options = $repo->all([IOption::FIELD__COMMANDS_NAMES => $commandName]);

        foreach ($options as $option) {
            if (isset($reserved[$option->getName()]) || isset($reserved[$option->getShortcut()])) {
                continue;
            }
            $this->addOption(...$option->__toInputOption());
        }

        return $this;
    }
}
