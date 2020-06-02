<?php
namespace extas\components\options;

use extas\interfaces\options\ICommandOption;
use extas\interfaces\repositories\IRepository;

/**
 * Trait TConfigure
 *
 * @method IRepository commandOptionRepository()
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
         * @var $options ICommandOption[]
         */
        $repo = $this->commandOptionRepository();
        $options = $repo->all([ICommandOption::FIELD__COMMANDS_NAMES => $commandName]);

        foreach ($options as $option) {
            if (isset($reserved[$option->getName()]) || isset($reserved[$option->getShortcut()])) {
                continue;
            }
            $this->addOption(...$option->__toInputOption());
        }

        return $this;
    }
}
