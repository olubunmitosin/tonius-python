<?php

namespace tonius\python;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use tonius\python\Exceptions\DoesNotExistException;
use tonius\python\Exceptions\InvalidFileException;
use tonius\python\Exceptions\InvalidOutputException;

trait Utilities
{
    /**
     * @var string
     */
    private static $testKey = 'test';

    /**
     * @var string
     */
    private static $extension = 'py';

    /**
     * @var string[]
     */
    private static $acceptableTypes = ['json', 'file', 'raw'];

    /**
     * @var string
     */
    private static $exampleScript = 'example'.DIRECTORY_SEPARATOR.'script.py';

    /**
     * Default python scripts
     * Directory.
     * @var string
     */
    private static $pythonDir = 'pythonDir';

    /**
     * Default output
     * Directory.
     * @var string
     */
    private static $outputDir = 'pythonDir'.DIRECTORY_SEPARATOR.'output';

    /**
     * Config Key for python scripts Dir.
     * @var string
     */
    private static $configPythonDirKey = 'python_dir';

    /**
     * Config Key for output Dir.
     * @var string
     */
    private static $configOutputDirKey = 'output_dir';

    /**
     * Check if config path was migrated
     * so it can use the values defined by user.
     * @return bool
     */
    private static function isConfigMigrated()
    {
        return Config::has(self::$configPythonDirKey) && Config::has(self::$configOutputDirKey);
    }

    /**
     * Get paths to be used by the package,
     * if not user defined, get default.
     *
     * @return array
     */
    private static function getDirPaths()
    {
        return self::isConfigMigrated() ?
            [Config::get(self::$configPythonDirKey), Config::get(self::$configOutputDirKey)] :
            [self::$pythonDir, self::$outputDir];
    }

    /**
     * Check if paths and directories
     * are in place for use.
     * @return bool
     */
    private static function pathsExist()
    {
        return
            is_dir(public_path().DIRECTORY_SEPARATOR.self::getDirPaths()[0])
            &&
            is_dir(public_path().DIRECTORY_SEPARATOR.self::getDirPaths()[1]);
    }

    /**
     * Create the desired paths.
     * @param $paths
     * @return void
     */
    private static function createDir($paths)
    {
        mkdir(public_path().DIRECTORY_SEPARATOR.$paths[0], 0777, true);
        mkdir(public_path().DIRECTORY_SEPARATOR.$paths[1], 0777, true);
    }

    /**
     * Check and prepare directories for use.
     * @return void
     */
    private static function prepareDirectories()
    {
        if (! self::pathsExist()) {
            self::createDir(self::getDirPaths());
        }
    }

    private static function getExtension($file)
    {
        return explode('.', $file)[1];
    }

    /**
     * Validate arguments.
     * @param $fileName
     * @param $options
     * @return void
     */
    private static function validateParameters($fileName, $options)
    {
        if (is_null($fileName) && empty($options)) {
            throw new InvalidFileException($fileName);
        }

        if (is_null($fileName) && (! isset($options[self::$testKey]) || ! $options[self::$testKey])) {
            throw new InvalidFileException($fileName);
        }

        // Validate output type
        self::validateOutPutType($options);
    }

    /**
     * Get valid script path.
     *
     * @param $fileName
     * @return string
     */
    private static function getFileFullPath($fileName)
    {
        // Get paths
        $paths = self::getDirPaths();
        //Get base path
        $basePath = public_path().DIRECTORY_SEPARATOR.$paths[0];

        if (is_null($fileName)) {
            $fullPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.self::$exampleScript;
        } else {
            $fullPath = $basePath.DIRECTORY_SEPARATOR.$fileName;
            if (! file_exists($fullPath)) {
                throw new DoesNotExistException($fileName);
            }
            if (self::getExtension($fileName) !== self::$extension) {
                throw new InvalidFileException($fileName);
            }
        }

        //return valid file path.
        return $fullPath;
    }

    /**
     * Run the script and return result.
     * @param $scriptPath
     * @return string
     */
    private static function runScript($scriptPath)
    {
        $process = new Process(['python', $scriptPath]);
        $process->run();

        //if not successful
        if (! $process->isSuccessful()) {
            //throw error and exit process
            throw new ProcessFailedException($process);
        }
        //process is successful, return process output
        return $process->getOutput();
    }

    /**
     * Validate output type.
     * @param $options
     */
    private static function validateOutPutType($options)
    {
        if (isset($options['output'])) {
            if (! in_array($options['output'], self::$acceptableTypes)) {
                throw new InvalidOutputException($options['output']);
            }

            if ($options['output'] === 'file' && ! isset($options['fileName'])) {
                throw new InvalidFileException(null);
            }
        }
    }

    /**
     * Write output to file.
     * @param $content
     * @param $path
     */
    private static function outPutToFile($content, $path)
    {
        // Get paths
        $paths = self::getDirPaths();
        //Get base path
        $basePath = public_path().DIRECTORY_SEPARATOR.$paths[1];
        $fullPath = $basePath.DIRECTORY_SEPARATOR.$path;

        //put contents into file. create file if not already created.
        file_put_contents($fullPath, $content);
    }

    /**
     * Handle response.
     * @param $content
     * @param $options
     * @return array
     */
    private static function handleResponse($content, $options)
    {
        $message = 'Your script ran successfully';
        $result = $content;

        if (isset($options['output'])) {
            if ($options['output'] === 'json') {
                $result = json_encode($content);
            }

            if ($options['output'] === 'file') {
                self::outPutToFile($content, $options['fileName']);
                $message = 'Your result has been written to file successfully';
            }
        }

        return [
            'success' => true,
            'message' => $message,
            'result' => $result,
        ];
    }
}
