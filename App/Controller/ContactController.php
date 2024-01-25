<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\ContactRepository;

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

    public function addContact(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $contactRepository = new ContactRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['contact-code-name']) && !empty($_POST['contact-birthday']) && !empty($_POST['contact-nationality'])) {
                $codeName = $_POST['contact-code-name'];
                $firstname = $_POST['contact-firstname'] ?? "";;
                $lastname = $_POST['contact-lastname'] ?? "";;
                $birthday = $_POST['contact-birthday'];
                $nationality = $_POST['contact-nationality'];

                $success = $contactRepository->insertContact($codeName, $firstname, $lastname, $birthday, $nationality);
                if ($success) {
                    header('Location: ?controller=contact&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=contact&action=list&message=addFail');
                }
            } else {
                throw new Exception("No contact codename, birthday, nationality send");
            }
        }
        require(__DIR__ . '/../../templates/admin/contact/add.php');
    }

    public function removeContact(string $SessionUuid): void
    {
        $contactRepository = new ContactRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $uuid = $_POST['delete'];

                $success = $contactRepository->deleteContact($uuid);
                if (!$success) {
                    throw new Exception("Unable to delete contact");
                }
            } else {
                throw new Exception("No contact id send");
            }
        }
    }

    public function editContact(string $SessionUuid, string $contactUuid): void
    {
        $adminRepository = new AdminRepository();
        $contactRepository = new ContactRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $contact = $contactRepository->getContact($contactUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['contact-uuid']) && !empty($_POST['contact-code-name']) && !empty($_POST['contact-birthday']) && !empty($_POST['contact-nationality'])) {
                $uuid = $_POST['contact-uuid'];
                $codeName = $_POST['contact-code-name'];
                $firstname = $_POST['contact-firstname'] ?? "";
                $lastname = $_POST['contact-lastname'] ?? "";
                $birthday = $_POST['contact-birthday'];
                $nationality = $_POST['contact-nationality'];

                $success = $contactRepository->updateContact($uuid, $codeName, $firstname, $lastname, $birthday, $nationality);
                if ($success) {
                    header('Location: ?controller=contact&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=contact&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No contact uuid and/or email send");
            }
        }
        require(__DIR__ . '/../../templates/admin/contact/edit.php');
    }
}
