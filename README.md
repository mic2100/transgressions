# Transgressions

This is designed to be use in conjunction with a custom error handler.

You can pass an exception to the agitator along with optional metadata. 

This can then be converted into an array, or you can use the messenger to sent it the website-tools API.

The agitator class will add additional information to the stack trace. It will now include file snippets from 
where the error occurred in the code. This allows for pretty outputting of the errors in external clients.

**Simple Usage**
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Transgressions\Agitator;
use Transgressions\Metadata\Exception as MetadataException;
use Transgressions\Metadata\Query as QueryMetadata;
use TransgressionsTest\Utility\NestedException;
use Throwable;

function testException()
{
    try {
        echo 'Testing Whoops Inspector' . PHP_EOL;

        (new NestedException)->test();
    } catch (Throwable $exception) {
        $mdException = new MetadataException($exception);
        $processDigest = Agitator::getInstance();
        $processDigest->setException($mdException);
        $processDigest->addMetadata(new QueryMetadata(
            'SELECT * FROM table WHERE id > ? AND id < ?',
            [10, 100],
            12.43
        ));

        echo json_encode($processDigest->toArray(), JSON_PRETTY_PRINT);
    }
}

testException();
```

This example would output the following:

```json
{
    "exception": {
        "message": "Testing",
        "file": "\/var\/www\/tests\/Utility\/NestedException.php",
        "line": 52,
        "code": 0,
        "previous": [],
        "trace": [
            {
                "message": "Testing",
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 52,
                "code": 0,
                "file-data": {
                    "43": "        $this->test6();\n",
                    "44": "    }\n",
                    "45": "\n",
                    "46": "    \/**\n",
                    "47": "     * @throws \\Exception\n",
                    "48": "     *\/\n",
                    "49": "    private function test6(): void\n",
                    "50": "    {\n",
                    "51": "        throw new \\Exception('Testing');\n",
                    "52": "    }\n"
                }
            },
            {
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 44,
                "function": "test6",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "35": "        $this->test5();\n",
                    "36": "    }\n",
                    "37": "\n",
                    "38": "    \/**\n",
                    "39": "     * @throws \\Exception\n",
                    "40": "     *\/\n",
                    "41": "    private function test5(): void\n",
                    "42": "    {\n",
                    "43": "        $this->test6();\n",
                    "44": "    }\n",
                    "45": "\n",
                    "46": "    \/**\n",
                    "47": "     * @throws \\Exception\n",
                    "48": "     *\/\n",
                    "49": "    private function test6(): void\n",
                    "50": "    {\n"
                }
            },
            {
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 36,
                "function": "test5",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "27": "        $this->test4();\n",
                    "28": "    }\n",
                    "29": "\n",
                    "30": "    \/**\n",
                    "31": "     * @throws \\Exception\n",
                    "32": "     *\/\n",
                    "33": "    private function test4(): void\n",
                    "34": "    {\n",
                    "35": "        $this->test5();\n",
                    "36": "    }\n",
                    "37": "\n",
                    "38": "    \/**\n",
                    "39": "     * @throws \\Exception\n",
                    "40": "     *\/\n",
                    "41": "    private function test5(): void\n",
                    "42": "    {\n"
                }
            },
            {
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 28,
                "function": "test4",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "19": "        $this->test3();\n",
                    "20": "    }\n",
                    "21": "\n",
                    "22": "    \/**\n",
                    "23": "     * @throws \\Exception\n",
                    "24": "     *\/\n",
                    "25": "    private function test3(): void\n",
                    "26": "    {\n",
                    "27": "        $this->test4();\n",
                    "28": "    }\n",
                    "29": "\n",
                    "30": "    \/**\n",
                    "31": "     * @throws \\Exception\n",
                    "32": "     *\/\n",
                    "33": "    private function test4(): void\n",
                    "34": "    {\n"
                }
            },
            {
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 20,
                "function": "test3",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "11": "        $this->test2();\n",
                    "12": "    }\n",
                    "13": "\n",
                    "14": "    \/**\n",
                    "15": "     * @throws \\Exception\n",
                    "16": "     *\/\n",
                    "17": "    private function test2(): void\n",
                    "18": "    {\n",
                    "19": "        $this->test3();\n",
                    "20": "    }\n",
                    "21": "\n",
                    "22": "    \/**\n",
                    "23": "     * @throws \\Exception\n",
                    "24": "     *\/\n",
                    "25": "    private function test3(): void\n",
                    "26": "    {\n"
                }
            },
            {
                "file": "\/var\/www\/tests\/Utility\/NestedException.php",
                "line": 12,
                "function": "test2",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "3": "\n",
                    "4": "class NestedException\n",
                    "5": "{\n",
                    "6": "    \/**\n",
                    "7": "     * @throws \\Exception\n",
                    "8": "     *\/\n",
                    "9": "    public function test(): void\n",
                    "10": "    {\n",
                    "11": "        $this->test2();\n",
                    "12": "    }\n",
                    "13": "\n",
                    "14": "    \/**\n",
                    "15": "     * @throws \\Exception\n",
                    "16": "     *\/\n",
                    "17": "    private function test2(): void\n",
                    "18": "    {\n"
                }
            },
            {
                "file": "\/var\/www\/test.php",
                "line": 16,
                "function": "test",
                "class": "TransgressionsTest\\Utility\\NestedException",
                "type": "->",
                "args": [],
                "file-data": {
                    "7": "use TransgressionsTest\\Utility\\NestedException;\n",
                    "8": "use Throwable;\n",
                    "9": "\n",
                    "10": "function testException()\n",
                    "11": "{\n",
                    "12": "    try {\n",
                    "13": "        echo 'Testing Whoops Inspector' . PHP_EOL;\n",
                    "14": "\n",
                    "15": "        (new NestedException)->test();\n",
                    "16": "    } catch (Throwable $exception) {\n",
                    "17": "        $mdException = new MetadataException($exception);\n",
                    "18": "        $processDigest = Agitator::getInstance();\n",
                    "19": "        $processDigest->setException($mdException);\n",
                    "20": "        $processDigest->addMetadata(new QueryMetadata(\n",
                    "21": "            'SELECT * FROM table WHERE id > ? AND id < ?',\n",
                    "22": "            [10, 100],\n"
                }
            },
            {
                "file": "\/var\/www\/test.php",
                "line": 31,
                "function": "testException",
                "args": [],
                "file-data": {
                    "22": "            [10, 100],\n",
                    "23": "            12.43\n",
                    "24": "        ));\n",
                    "25": "\n",
                    "26": "        echo json_encode($processDigest->toArray(), JSON_PRETTY_PRINT);\n",
                    "27": "    }\n",
                    "28": "}\n",
                    "29": "\n"
                }
            }
        ]
    },
    "metadata": {
        "query": [
            {
                "sql": "SELECT * FROM table WHERE id > ? AND id < ?",
                "bindings": [
                    10,
                    100
                ],
                "time": 12.43
            }
        ]
    }
}
```
