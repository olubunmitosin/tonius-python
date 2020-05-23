import json
import logging
import platform
import psutil


def system_info():
    try:
        info = {
            'platform': platform.system(),
            'platform_release': platform.release(),
            'platform_version': platform.version(),
            'architecture': platform.machine(),
            'processor': platform.processor(),
            'ram': str(round(psutil.virtual_memory().total / (1024.0 ** 3))) + " GB"
        }

        return json.dumps(info)

    except Exception as e:

        logging.exception(e)


print(system_info())
