<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\ContactRepository;
use Random\RandomException;

class ContactController
{
    public function listContact(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $contactRepository = new ContactRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $contactPerPage = 10;
        $pagination = $contactRepository->getPaginationForContacts($contactPerPage, $search);
        $contacts = $contactRepository->getContactsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/contact/list.php');
    }

    /**
     * @throws Exception
     */
    public function addContact(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $contactRepository = new ContactRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['contact-code-name']) && !empty($_POST['contact-birthday']) && !empty($_POST['contact-nationality'])) {
                    $codeName = htmlspecialchars($_POST['contact-code-name']);
                    $firstname = htmlspecialchars($_POST['contact-firstname'] ?? "");;
                    $lastname = htmlspecialchars($_POST['contact-lastname'] ?? "");;
                    $birthday = htmlspecialchars($_POST['contact-birthday']);
                    $nationality = htmlspecialchars($_POST['contact-nationality']);

                    $success = $contactRepository->insertContact($codeName, $firstname, $lastname, $birthday, $nationality);
                    if ($success) {
                        header('Location: ?controller=contact&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=contact&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No contact codename, birthday, nationality send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/contact/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeContact(string $SessionUuid): void
    {
        $contactRepository = new ContactRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $uuid = htmlspecialchars($_POST['delete']);

                    $success = $contactRepository->deleteContact($uuid);
                    if (!$success) {
                        throw new Exception("Unable to delete contact");
                    }
                } else {
                    throw new Exception("No contact id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editContact(string $SessionUuid, string $contactUuid): void
    {
        $adminRepository = new AdminRepository();
        $contactRepository = new ContactRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $contact = $contactRepository->getContact($contactUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['contact-uuid']) && !empty($_POST['contact-code-name']) && !empty($_POST['contact-birthday']) && !empty($_POST['contact-nationality'])) {
                    $uuid = htmlspecialchars($_POST['contact-uuid']);
                    $codeName = htmlspecialchars($_POST['contact-code-name']);
                    $firstname = htmlspecialchars($_POST['contact-firstname'] ?? "");
                    $lastname = htmlspecialchars($_POST['contact-lastname'] ?? "");
                    $birthday = htmlspecialchars($_POST['contact-birthday']);
                    $nationality = htmlspecialchars($_POST['contact-nationality']);

                    $success = $contactRepository->updateContact($uuid, $codeName, $firstname, $lastname, $birthday, $nationality);
                    if ($success) {
                        header('Location: ?controller=contact&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=contact&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No contact uuid and/or email send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/contact/edit.php');
    }
}
