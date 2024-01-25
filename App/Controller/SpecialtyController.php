<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\SpecialtyRepository;

class SpecialtyController
{
    public function listSpecialty(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $specialtiesPerPage = 10;

        $pagination = $specialtyRepository->getPaginationForSpecialties($specialtiesPerPage, $search);
        $specialties = $specialtyRepository->getSpecialtiesWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/specialty/list.php');
    }

    public function addSpecialty(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['specialty-name'])) {
                $name = $_POST['specialty-name'];

                $success = $specialtyRepository->insertSpecialty($name);
                if ($success) {
                    header('Location: ?controller=specialty&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=specialty&action=list&message=addFail');
                }
            } else {
                throw new Exception("No specialty name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/specialty/add.php');
    }

    public function removeSpecialty(string $SessionUuid): void
    {
        $specialtyRepository = new SpecialtyRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $id = $_POST['delete'];

                $success = $specialtyRepository->deleteSpecialty($id);
                if (!$success) {
                    throw new Exception("Unable to delete specialty");
                }
            } else {
                throw new Exception("No specialty id send");
            }
        }
    }

    public function editSpecialty(string $SessionUuid, int $specialtyId): void
    {
        $adminRepository = new AdminRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $specialty = $specialtyRepository->getSpecialty($specialtyId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['specialty-id']) && !empty($_POST['specialty-name'])) {
                $id = $_POST['specialty-id'];
                $name = $_POST['specialty-name'];

                $success = $specialtyRepository->updateSpecialty($id, $name);
                if ($success) {
                    header('Location: ?controller=specialty&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=specialty&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No specialty id and/or name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/specialty/edit.php');
    }
}
