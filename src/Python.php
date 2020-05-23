<?php

namespace tonius\python;

class Python implements PythonInterface
{
    use Utilities;

    public static function run( $fileName = null, $options = [] )
    {
        // Validate directories and paths, if they do not exist,
        // create the default paths
        self::prepareDirectories();

        // Validate argument parameters before proceeding
        self::validateParameters( $fileName, $options );

        //Get script full path.
        $result = self::runScript(self::getFileFullPath( $fileName ));

        return self::handleResponse($result, $options);
    }
}
