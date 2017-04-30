<?php
/**
 * Class PlatformInstallerPlugin
 */
namespace Moro\Platform\Installer;
use \Composer\Composer;
use \Composer\IO\IOInterface;
use \Composer\Package\CompletePackage;
use \Composer\Plugin\PluginInterface;
use \Composer\Repository\ArrayRepository;
use \ComponentInstaller\Installer as ComponentInstaller;

/**
 * Class PlatformInstallerPlugin
 * @package Moro\Platform\Installer
 */
class ComposerPlugin implements PluginInterface
{
	/**
	 * Called when the plugin is activated.
	 *
	 * @param Composer $composer
	 * @param IOInterface $io
	 */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);

        $installer = new ComponentInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);

        for ($path = $project = __DIR__; strlen($path) > 3; $path = dirname($path))
        {
            if (file_exists($path.DIRECTORY_SEPARATOR.'composer.json'))
            {
                $project = $path;
            }
        }

        $repository = new ArrayRepository();

        foreach (json_decode(file_get_contents(__DIR__.'/../../repositories.json'), true) as $config)
        {
            $package = new CompletePackage($config['package']['name'], $config['package']['version'], $config['package']['version']);
            $package->setType('package');
            $package->setDistType($config['package']['dist']['type']);
            $package->setDistUrl($config['package']['dist']['url']);

            $repository->addPackage($package);
        }

        $composer->getRepositoryManager()->addRepository($repository);

        /** @noinspection PhpIncludeInspection */
        require_once(implode(DIRECTORY_SEPARATOR, [$project, 'vendor', 'leafo', 'lessphp', 'lessc.inc.php']));
    }
}