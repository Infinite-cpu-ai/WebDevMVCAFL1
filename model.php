<?php
// model.php
class Pokemon
{
    private $id;
    private $name;
    private $weight;
    private $species;
    private $type_id;

    public function __construct($id, $name, $weight, $species, $type_id = null)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setWeight($weight);
        $this->setSpecies($species);
        $this->setTypeId($type_id);
    }

    private function setId($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID must be numeric");
        }
        $this->id = (int)$id;
    }

    private function setName($name)
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Name cannot be empty");
        }
        $this->name = trim($name);
    }

    private function setWeight($weight)
    {
        if (!is_numeric($weight) || $weight <= 0) {
            throw new InvalidArgumentException("Weight must be a positive number");
        }
        $this->weight = floatval($weight);
    }

    private function setSpecies($species)
    {
        if (empty(trim($species))) {
            throw new InvalidArgumentException("Species cannot be empty");
        }
        $this->species = trim($species);
    }

    private function setTypeId($type_id)
    {
        if ($type_id !== null && !is_numeric($type_id)) {
            throw new InvalidArgumentException("Type ID must be numeric or null");
        }
        $this->type_id = $type_id === null ? null : (int)$type_id;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'weight' => $this->weight,
            'species' => $this->species,
            'type_id' => $this->type_id
        ];
    }
}

class Type
{
    private $id;
    private $name;
    private $pro;
    private $contra;

    public function __construct($id, $name, $pro, $contra)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPro($pro);
        $this->setContra($contra);
    }

    private function setId($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID must be numeric");
        }
        $this->id = (int)$id;
    }

    private function setName($name)
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Name cannot be empty");
        }
        $this->name = trim($name);
    }

    private function setPro($pro)
    {
        if (empty(trim($pro))) {
            throw new InvalidArgumentException("Pro cannot be empty");
        }
        $this->pro = trim($pro);
    }

    private function setContra($contra)
    {
        if (empty(trim($contra))) {
            throw new InvalidArgumentException("Contra cannot be empty");
        }
        $this->contra = trim($contra);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pro' => $this->pro,
            'contra' => $this->contra
        ];
    }
}
