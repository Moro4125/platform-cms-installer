<?php
/**
 * Class PlatformInstallerPlugin
 */
namespace Moro\Platform\Installer;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class PlatformInstallerPlugin
 * @package Moro\Platform\Installer
 */
class ComposerPlugin implements PluginInterface
{
    /**
     * Called when the plugin is activated.
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new \ComponentInstaller\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
