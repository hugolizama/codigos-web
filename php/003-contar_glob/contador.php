<?php
echo "Contador: ". count(glob("archivos/{*.txt,*.jpg}",GLOB_BRACE));