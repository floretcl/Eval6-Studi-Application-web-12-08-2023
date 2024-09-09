<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\HideoutRepository;
use App\Repository\HideoutTypeRepository;

class HideoutController
{
    public function listHideout(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $hideoutRepository = new HideoutRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $hideoutPerPage = 10;

        $pagination = $hideoutRepository->getPaginationForHideouts($hideoutPerPage, $search);
        $hideouts = $hideoutRepository->getHideoutsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/hideout/list.php');
    }

    /**
     * @throws Exception
     */
    public function addHideout(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $hideoutRepository = new HideoutRepository();
        $hideoutTypeRepository = new HideoutTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $hideoutTypes = $hideoutTypeRepository->getHideoutTypes();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['hideout-code-name']) && !empty($_POST['hideout-address']) && !empty($_POST['hideout-country']) && !empty($_POST['hideout-type'])) {
                    $codeName = htmlspecialchars($_POST['hideout-code-name']);
                    $address = htmlspecialchars($_POST['hideout-address']);
                    $country = htmlspecialchars($_POST['hideout-country']);
                    $type = htmlspecialchars($_POST['hideout-type']);

                    $success = $hideoutRepository->insertHideout($codeName, $address, $country, $type);
                    if ($success) {
                        header('Location: ?controller=hideout&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=hideout&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No hideout codename, address, country, type send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/hideout/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeHideout(string $SessionUuid): void
    {
        $hideoutRepository = new HideoutRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $uuid = htmlspecialchars($_POST['delete']);

                    $success = $hideoutRepository->deleteHideout($uuid);
                    if (!$success) {
                        throw new Exception("Unable to delete hideout");
                    }
                } else {
                    throw new Exception("No hideout id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editHideout(string $SessionUuid, string $hideoutUuid): void
    {
        $adminRepository = new AdminRepository();
        $hideoutRepository = new HideoutRepository();
        $hideoutTypeRepository = new HideoutTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $hideout = $hideoutRepository->getHideout($hideoutUuid);
        $hideoutTypes = $hideoutTypeRepository->getHideoutTypes();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['hideout-uuid']) && !empty($_POST['hideout-code-name']) && !empty($_POST['hideout-address']) && !empty($_POST['hideout-country']) && !empty($_POST['hideout-type'])) {
                    $uuid = htmlspecialchars($_POST['hideout-uuid']);
                    $codeName = htmlspecialchars($_POST['hideout-code-name']);
                    $address = htmlspecialchars($_POST['hideout-address']);
                    $country = htmlspecialchars($_POST['hideout-country']);
                    $type = htmlspecialchars($_POST['hideout-type']);

                    $success = $hideoutRepository->updateHideout($uuid, $codeName, $address, $country, $type);
                    if ($success) {
                        header('Location: ?controller=hideout&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=hideout&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No hideout uuid, codename, address, country, type send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/hideout/edit.php');
    }
}
