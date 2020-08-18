<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/students")
 */

class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    /**
     * @Route("/", name="add_student", methods={"POST"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return JsonResponse
     * @throws \JsonException
     */
    public function add(Request $request, TeacherRepository $teacherRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        foreach ($data as $field) {
            if (empty($field)) {
                throw new NotFoundHttpException('Missing required input!');
            }
        }

        $address = new Address($data['address']['street'], $data['address']['streetNumber'], $data['address']['city'], $data['address']['zipcode']);
        $teacher = $teacherRepository->findOneBy(['id' => $data['teacher_id']]);

        if ($teacher === null) {
            throw new NotFoundHttpException('Teacher with the requested ID is not found!');
        }

        $student = new Student($data['firstName'], $data['lastName'],$data['email'],$address,$teacher);
        $manager = $this->studentRepository->getManager();
        $manager->persist($student);
        $manager->flush();

        return new JsonResponse(['status' => 'Student added!'], Response::HTTP_OK);
    }

    /**
     * @Route("/all", name="get_all_students", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $students = $this->studentRepository->findAll();

        if ($students === null) {
            throw new NotFoundHttpException('No student found!');
        }

        $data = [];
        foreach ($students as $student) {
            $data[] = $student->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("/{id}", name="get_one_student", methods={"GET"})
     * @param Student $student
     * @return JsonResponse
     */
    public function get(string $id): JsonResponse{
        // YOU CAN ALSO DO IT LIKE THE PUT BECAUSE SYMFONY AUTOMICALLY LOOKS FOR IT
        $student= $this->studentRepository->findOneBy(['id' => $id]);
        if ($student === null) {
            throw new NotFoundHttpException('Student with the requested ID is not found!');
        }

        $data = $student->toArray();
        return new JsonResponse($data, Response::HTTP_OK);
    }



    /**
     * @Route("/{id}", name="update_student", methods={"PUT"})
     * @param Student $student
     * @return JsonResponse
     */
    public function update(Student $student, Request $request, TeacherRepository $teacherRepository): JsonResponse
    {
        if ($student === null) {
            throw new NotFoundHttpException('Student with the requested ID is not found!');
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        empty($data['firstName']) ? true : $student->setFirstName($data['firstName']);
        empty($data['lastName']) ? true : $student->setLastName($data['lastName']);
        empty($data['email']) ? true : $student->setEmail($data['email']);
        empty($data['address']['street']) ? true : $student->getAddress()->setStreet($data['address']['street']);
        empty($data['address']['streetNumber']) ? true : $student->getAddress()->setStreetNumber($data['address']['streetNumber']);
        empty($data['address']['city']) ? true : $student->getAddress()->setCity($data['address']['city']);
        empty($data['address']['zipcode']) ? true : $student->getAddress()->setZipcode($data['address']['zipcode']);
        empty($data['teacher_id']) ? true : $student->setTeacher($teacherRepository->findOneBy(['id' => $data['teacher_id']]));

        $manager = $this->studentRepository->getManager();
        $manager->persist($student);
        $manager->flush();


        return new JsonResponse($student->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="delete_student", methods={"DELETE"})
     * @param Student $student
     * @return JsonResponse
     */
    public function delete(Student $student): JsonResponse
    {
        if ($student === null) {
            throw new NotFoundHttpException('Student with the requested ID is not found!');
        }

        $manager = $this->studentRepository->getManager();
        $manager->remove($student);
        $manager->flush();


        return new JsonResponse(['status' => 'Student deleted!'], Response::HTTP_NO_CONTENT);
    }
}