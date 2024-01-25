<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\DetailController;
use App\Controller\AdministrationController;
use App\Controller\AdminController;
use App\Controller\AgentController;
use App\Controller\ContactController;
use App\Controller\HideoutController;
use App\Controller\HideoutTypeController;
use App\Controller\MissionController;
use App\Controller\MissionStatusController;
use App\Controller\MissionTypeController;
use App\Controller\SpecialtyController;
use App\Controller\TargetController;
use App\Controller\ErrorController;

// Loading dotenv to load .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    if (isset($_GET['controller']) && $_GET['controller'] !== '') {
        if ($_GET['controller'] == 'detail' && isset($_GET['id'])) {
            $detailController = new DetailController();
            $detailController->detail($_GET['id']);
        } elseif ($_GET['controller'] == 'auth') {
            $authController = new AuthController();
            if ($_GET['action'] == 'login') {
                $authController->login();
            }
        } elseif ($_GET['controller'] == 'administration') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $administrationController = new AdministrationController();
                $administrationController->admin($_SESSION['uuid']);
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'admin') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $adminController = new AdminController();
                if ($_GET['action'] == 'list') {
                    $adminController->listAdmin($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $adminController->removeAdmin($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $adminController->addAdmin($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $adminController->editAdmin($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'mission') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $missionController = new MissionController();
                if ($_GET['action'] == 'list') {
                    $missionController->listMission($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $missionController->removeMission($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $missionController->addMission($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $missionController->editMission($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'hideout') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $hideoutController = new HideoutController();
                if ($_GET['action'] == 'list') {
                    $hideoutController->listHideout($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $hideoutController->removeHideout($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $hideoutController->addHideout($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $hideoutController->editHideout($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'agent') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $agentController = new AgentController();
                if ($_GET['action'] == 'list') {
                    $agentController->listAgent($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $agentController->removeAgent($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $agentController->addAgent($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $agentController->editAgent($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'contact') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $contactController = new ContactController();
                if ($_GET['action'] == 'list') {
                    $contactController->listContact($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $contactController->removeContact($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $contactController->addContact($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $contactController->editContact($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'target') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $targetController = new TargetController();
                if ($_GET['action'] == 'list') {
                    $targetController->listTarget($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $targetController->removeTarget($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $targetController->addTarget($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $targetController->editTarget($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'mission-type') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $missionTypeController = new MissionTypeController();
                if ($_GET['action'] == 'list') {
                    $missionTypeController->listMissionType($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $missionTypeController->removeMissionType($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $missionTypeController->addMissionType($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $missionTypeController->editMissionType($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'mission-status') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $missionStatusController = new MissionStatusController();
                if ($_GET['action'] == 'list') {
                    $missionStatusController->listMissionStatus($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $missionStatusController->removeMissionStatus($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $missionStatusController->addMissionStatus($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $missionStatusController->editMissionStatus($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'hideout-type') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $hideoutTypeController = new HideoutTypeController();
                if ($_GET['action'] == 'list') {
                    $hideoutTypeController->listHideoutType($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $hideoutTypeController->removeHideoutType($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $hideoutTypeController->addHideoutType($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $hideoutTypeController->editHideoutType($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } elseif ($_GET['controller'] == 'specialty') {
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_SESSION['uuid'])) {
                $specialtyController = new SpecialtyController();
                if ($_GET['action'] == 'list') {
                    $specialtyController->listSpecialty($_SESSION['uuid'], $_POST['search'] ?? '');
                } elseif ($_GET['action'] == 'delete') {
                    $specialtyController->removeSpecialty($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'add') {
                    $specialtyController->addSpecialty($_SESSION['uuid']);
                } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
                    $specialtyController->editSpecialty($_SESSION['uuid'], $_GET['id']);
                } else {
                    throw new Exception("404: Resource not found");
                }
            } else {
                header('Location: ?controller=auth&action=login');
            }
        } else {
            throw new Exception("404: Resource not found");
        }
    } else {
        $homeController = new HomeController();
        $homeController->home();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    $errorController = new ErrorController();
    $errorController->error($errorMessage);
}
