<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class Hierarchy extends CModule
{
    var $MODULE_ID = "hierarchy";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";
    private $INSTALL_DIR;

    public function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->INSTALL_DIR = dirname(__file__);

        $this->MODULE_NAME = Loc::getMessage("HIERARCHY_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("HIERARCHY_INSTALL_DESCRIPTION");
    }


    function InstallDB($install_wizard = true)
    {
        RegisterModule("hierarchy");
        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        UnRegisterModule("hierarchy");
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        CopyDirFiles(
            $this->INSTALL_DIR . '/components',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components',
            true,
            true
        );

        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/components/hierarchy");
        return true;
    }

    function DoInstall(){
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUnInstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallDB(false);
    }
}
?>