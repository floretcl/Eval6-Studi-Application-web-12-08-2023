<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\SpecialtyRepository;
use Random\RandomException;

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

    /**
     * @throws Exception
     */
    public function addSpecialty(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['specialty-name'])) {
                    $name = htmlspecialchars($_POST['specialty-name']);

                    $success = $specialtyRepository->insertSpecialty($name);
                    if ($success) {
                        header('Location: ?controller=specialty&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=specialty&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No specialty name send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/specialty/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeSpecialty(string $SessionUuid): void
    {
        $specialtyRepository = new SpecialtyRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $id = htmlspecialchars($_POST['delete']);

                    $success = $specialtyRepository->deleteSpecialty($id);
                    if (!$success) {
                        throw new Exception("Unable to delete specialty");
                    }
                } else {
                    throw new Exception("No specialty id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editSpecialty(string $SessionUuid, int $specialtyId): void
    {
        $adminRepository = new AdminRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $specialty = $specialtyRepository->getSpecialty($specialtyId);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['specialty-id']) && !empty($_POST['specialty-name'])) {
                    $id = htmlspecialchars($_POST['specialty-id']);
                    $name = htmlspecialchars($_POST['specialty-name']);

                    $success = $specialtyRepository->updateSpecialty($id, $name);
                    if ($success) {
                        header('Location: ?controller=specialty&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=specialty&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No specialty id and/or name send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/specialty/edit.php');
    }
}
