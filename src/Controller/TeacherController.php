<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Entity\Address;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
/**
 * @Route("/teachers")
 */
class TeacherController
{
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     *@Route("/", name="add_teacher", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \JsonException
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $name = $data['name'];
        $email = $data['email'];


        foreach ($data as $field) {
            if (empty($field)) {
                throw new NotFoundHttpException('Missing required input!');
            }
        }

        $address = new Address($data['address']['street'], $data['address']['streetNumber'], $data['address']['city'], $data['address']['zipcode']);
        $newTeacher=new Teacher($name, $email, $address);
        $manager=$this->teacherRepository->getManager();
        $manager->persist($newTeacher);
        $manager->flush();

        return new JsonResponse(['status' => 'Teacher created!'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/all", name="get_all_teachers", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $teachers = $this->teacherRepository->findAll();
        $data = [];

        if ($teachers === null) {
            throw new NotFoundHttpException('No teacher found!');
        }

        foreach ($teachers as $teacher) {
            $data[] = $teacher->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @route("/{id}", name="get_teacher", methods={"GET"})
     */
    public function get(int $id): JsonResponse{
        // YOU CAN ALSO DO IT LIKE THE PUT BECAUSE SYMFONY AUTOMICALLY LOOKS FOR IT
        $teacher= $this->teacherRepository->findOneBy(['id' => $id]);

        if ($teacher === null) {
            throw new NotFoundHttpException('Teacher with the requested ID is not found!');
        }

        $data = $teacher->toArray();
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="update_teacher", methods={"PUT"})
     */
    public function update(Teacher $teacher, Request $request): JsonResponse
    {
        if ($teacher === null) {
            throw new NotFoundHttpException('Teacher with the requested ID is not found!');
        }
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $teacher->setName($data['name']);
        empty($data['email']) ? true : $teacher->setEmail($data['email']);
        empty($data['address']['street']) ? true : $teacher->getAddress()->setStreet($data['address']['street']);
        empty($data['address']['streetNumber']) ? true : $teacher->getAddress()->setStreetNumber($data['address']['streetNumber']);
        empty($data['address']['city']) ? true : $teacher->getAddress()->setCity($data['address']['city']);
        empty($data['address']['zipcode']) ? true : $teacher->getAddress()->setZipcode($data['address']['zipcode']);

        $manager=$this->teacherRepository->getManager();
        $manager->persist($teacher);
        $manager->flush();

        return new JsonResponse($teacher->toArray(), Response::HTTP_OK);
    }
    /**
     * @Route("/{id}", name="delete_teacher", methods={"DELETE"})
     */
    public function delete(Teacher $teacher): JsonResponse
    {
        if ($teacher === null) {
            throw new NotFoundHttpException('Teacher with the requested ID is not found!');
        }

        $manager=$this->teacherRepository->getManager();
        $manager->remove($teacher);
        $manager->flush();

        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }


}
