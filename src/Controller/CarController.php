<?php
namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use App\Service\CarService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends ApiController
{
    /**
     * @Route("/car/{id}", methods="GET")
     */
    public function show(int $id, CarRepository $carRepository)
    {
        $car = $carRepository->findOne($id);
        if ($car === null) {
            return $this->respondNotFound();
        }

        return $this->respond($carRepository->transform($car));
    }

    /**
     * @Route("/car", methods="POST")
     */
    public function create(Request $request, CarService $carService, CarRepository $carRepository)
    {
        $car = new Car();

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $car = $carService->saveCar($form->getData());

            return $this->respond($carRepository->transform($car));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/car/{id}", methods="POST")
     */
    public function update(Request $request, CarRepository $carRepository, CarService $carService)
    {
        $car = $carRepository->findOne($request->get('id'));
        if ($car === null) {
            return $this->respondNotFound();
        }

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $car = $carService->saveCar($form->getData());

            return $this->respond($carRepository->transform($car));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/car/{id}", methods="DELETE")
     */
    public function delete(Request $request, CarService $carService, CarRepository $carRepository)
    {
        $car = $carRepository->findOne($request->get('id'));
        if ($car === null) {
            return $this->respondNotFound();
        }

        $carService->deleteCar($car);

        return $this->respond([]);
    }
}