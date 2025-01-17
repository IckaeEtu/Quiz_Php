<?php
namespace Classes\Form;

use Classes\Form\InputRenderInterface;

abstract class GenericFormElement implements InputRenderInterface // Le mot clé abstract permet d'empécher l'instanciation de cette class
{
    protected string $type;

    protected bool $required = false;

    protected mixed $value = '';

    public function __construct(
        protected readonly string $name,
        $required = false,
        string $defaultValue = ''
    )
    {
        $this->required = $required;
        $this->value = $defaultValue;
    }

    public function getType(): string {
        return $this->type;
    }

    public function isRequired(): bool {
        return $this->required;
    }

    public function getValue(): mixed {
        return $this->value;
    }

    public function __toString(): string {
        return $this->render();
    }

    public function getName(): string {
        return $this->name;
    }

    public function setValue($value) {
        $this->value = $value;
    }
}
?>