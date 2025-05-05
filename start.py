import os
import subprocess
import time

subprocess.Popen(["code", "."], shell=True)

serve_process = subprocess.Popen(["php", "artisan", "serve"], shell=True)

time.sleep(5)

queue_process = subprocess.Popen(["php", "artisan", "queue:work", "--tries=3"], shell=True)

serve_process.wait()
queue_process.wait()

