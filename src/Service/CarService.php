<?php
namespace App\Service;

use App\Entity\Car;

class CarService extends AbstractService
{
    /**
     * @param \App\Entity\Car $car
     * @return \App\Entity\Car
     */
    public function saveCar(Car $car)
    {
        $this->persistRecord($car);

        return $car;
    }

    /**
     * @param \App\Entity\Car $car
     * @throws \Exception
     * @return void
     */
    public function deleteCar(Car $car): void
    {
        $this->softDeleteRecord($car);
    }
}