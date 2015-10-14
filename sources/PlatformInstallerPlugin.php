<?php
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class PlatformInstallerPlugin
 */
class PlatformInstallerPlugin implements PluginInterface
{
    /**
     * Called when the plugin is activated.
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new ComponentInstaller\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
