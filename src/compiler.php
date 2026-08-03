<?php

declare(strict_types=1);

namespace XLphp;

class Compiler
{
    private array $keywords = [
        'func' => 'function',
        'print' => 'echo',
        'give' => 'return',
        'create' => 'new',
        'me' => '$this',
        'when' => 'if',
        'otherwise' => 'else',
        'loop' => 'foreach',
        'yes' => 'true',
        'no' => 'false',
        'select' => 'switch',
        'option' => 'case',
        'stop' => 'break',
        'shell' => 'system',
        'type' => 'class',
        'where' => 'if'
    ];

    private array $cache = [];

    public function compileFile(string $file): string
    {
        $realPath = realpath($file);

        if (!$realPath) {
            throw new \RuntimeException("File not found: {$file}");
        }

        if (isset($this->cache[$realPath])) {
            return $this->cache[$realPath];
        }

        $code = file_get_contents($realPath);
        $compiled = $this->compile($code);

        $this->cache[$realPath] = $compiled;
        return $compiled;
    }

    public function compile(string $code): string
    {
        $code = $this->removeDollarSign($code);
        $code = $this->replaceKeywords($code);
        $code = $this->compileShortFunctions($code);
        $code = $this->compileObjectCreation($code);
        $code = $this->compileForLoops($code);
        $code = $this->compileStringInterpolation($code);
        $code = $this->compileArrayShortSyntax($code);
        $code = $this->compileWhileLoops($code);
        $code = $this->compileSwitchStatement($code);
        $code = $this->compileTernaryOperator($code);
        $code = $this->compileNullCoalesce($code);
        $code = $this->compileArrowFunctions($code);
        $code = $this->compilePropertyAccess($code);
        $code = $this->compileMethodCalls($code);
        $code = $this->compileStaticCalls($code);
        $code = $this->compileNamespaces($code);
        $code = $this->compileUseStatements($code);
        $code = $this->compileTraits($code);
        $code = $this->compileInterfaces($code);
        $code = $this->compileAbstractClasses($code);
        $code = $this->compileFinalClasses($code);
        $code = $this->compileConstants($code);
        $code = $this->compileEnumClasses($code);
        $code = $this->compileMatchExpression($code);
        $code = $this->compileAttributes($code);
        $code = $this->compileConstructorPropertyPromotion($code);
        $code = $this->compileNamedArguments($code);
        $code = $this->compileUnionTypes($code);
        $code = $this->compileIntersectionTypes($code);
        $code = $this->compileMixedType($code);
        $code = $this->compileVoidType($code);
        $code = $this->compileNeverType($code);
        $code = $this->compileStaticType($code);
        $code = $this->compileIterableType($code);
        $code = $this->compileCallableType($code);
        $code = $this->compileObjectType($code);
        $code = $this->compileArrayDestructuring($code);
        $code = $this->compileSpreadOperator($code);
        $code = $this->compileVariadicFunctions($code);
        $code = $this->compileGeneratorFunctions($code);
        $code = $this->compileYieldFrom($code);
        $code = $this->compileFinallyBlocks($code);
        $code = $this->compileThrowExpression($code);
        $code = $this->compileMatchAsExpression($code);
        $code = $this->compileReadonlyProperties($code);
        $code = $this->compileReadonlyClasses($code);
        $code = $this->compileTypedProperties($code);
        $code = $this->compileNullableTypes($code);
        $code = $this->compileArrayShapeSyntax($code);
        $code = $this->compileListSyntax($code);
        $code = $this->compileArrayUnpacking($code);
        $code = $this->compileStringableInterface($code);
        $code = $this->compileWeakMaps($code);
        $code = $this->compileFiberSupport($code);
        $code = $this->compileSensitiveParameters($code);
        $code = $this->compileAsymmetricVisibility($code);
        $code = $this->compileEnumBacked($code);
        $code = $this->compileEnumCases($code);
        $code = $this->compileEnumMethods($code);
        $code = $this->compileEnumConstants($code);
        $code = $this->compileEnumTraitUsage($code);
        $code = $this->compileNewInitializers($code);
        $code = $this->compilePropertyHooks($code);
        $code = $this->compileLazyObjects($code);
        $code = $this->compileFirstClassCallable($code);
        $code = $this->compileArrayIsList($code);
        $code = $this->compileErrorBacktrace($code);
        $code = $this->compileDeprecations($code);
        $code = $this->compileAttributeSyntax($code);
        $code = $this->compileClassConstantType($code);
        $code = $this->compileFunctionConstantType($code);
        $code = $this->compilePropertyConstantType($code);
        $code = $this->compileTrueFalseNull($code);
        $code = $this->compileMatchCondition($code);
        $code = $this->compileDefaultMatch($code);
        $code = $this->compileNamedParameters($code);
        $code = $this->compileArgumentUnpacking($code);
        $code = $this->compileAnonymousClasses($code);
        $code = $this->compileAnonymousFunctions($code);
        $code = $this->compileClosures($code);
        $code = $this->compileCallableTypes($code);
        $code = $this->compileIterableTypes($code);
        $code = $this->compileMixedTypes($code);
        $code = $this->compileVoidTypes($code);
        $code = $this->compileNeverTypes($code);
        $code = $this->compileStaticTypes($code);
        $code = $this->compileIterableTypesAdvanced($code);
        $code = $this->compileCallableTypesAdvanced($code);
        $code = $this->compileObjectTypes($code);
        $code = $this->compileArrayTypes($code);
        $code = $this->compileStringTypes($code);
        $code = $this->compileIntTypes($code);
        $code = $this->compileFloatTypes($code);
        $code = $this->compileBoolTypes($code);
        $code = $this->compileResourceTypes($code);
        $code = $this->compileNullTypes($code);
        $code = $this->compileScalarTypes($code);
        $code = $this->compileClassTypes($code);
        $code = $this->compileInterfaceTypes($code);
        $code = $this->compileTraitTypes($code);
        $code = $this->compileEnumTypes($code);
        $code = $this->compileFunctionTypes($code);
        $code = $this->compileMethodTypes($code);
        $code = $this->compilePropertyTypes($code);
        $code = $this->compileConstantTypes($code);
        $code = $this->compileVariableTypes($code);
        $code = $this->compileExpressionTypes($code);
        $code = $this->compileStatementTypes($code);
        $code = $this->compileBlockTypes($code);
        $code = $this->compileFileTypes($code);
        $code = $this->compileNamespaceTypes($code);
        $code = $this->compileUseTypes($code);
        $code = $this->compileImportTypes($code);
        $code = $this->compileExportTypes($code);
        $code = $this->compileIncludeTypes($code);
        $code = $this->compileRequireTypes($code);
        $code = $this->compileOnceTypes($code);
        $code = $this->compileGlobalTypes($code);
        $code = $this->compileStaticTypesAdvanced($code);
        $code = $this->compileSelfTypes($code);
        $code = $this->compileParentTypes($code);
        $code = $this->compileThisTypes($code);
        $code = $this->compileYieldTypes($code);
        $code = $this->compileReturnTypes($code);
        $code = $this->compileThrowTypes($code);
        $code = $this->compileCatchTypes($code);
        $code = $this->compileFinallyTypes($code);
        $code = $this->compileTryTypes($code);
        $code = $this->compileIfTypes($code);
        $code = $this->compileElseTypes($code);
        $code = $this->compileElseIfTypes($code);
        $code = $this->compileWhileTypes($code);
        $code = $this->compileDoWhileTypes($code);
        $code = $this->compileForTypes($code);
        $code = $this->compileForeachTypes($code);
        $code = $this->compileSwitchTypes($code);
        $code = $this->compileCaseTypes($code);
        $code = $this->compileDefaultTypes($code);
        $code = $this->compileBreakTypes($code);
        $code = $this->compileContinueTypes($code);
        $code = $this->compileExitTypes($code);
        $code = $this->compileDieTypes($code);
        $code = $this->compileEvalTypes($code);
        $code = $this->compileSystemTypes($code);
        $code = $this->compileExecTypes($code);
        $code = $this->compilePassthruTypes($code);
        $code = $this->compileShellExecTypes($code);
        $code = $this->compileBacktickTypes($code);
        $code = $this->compilePHPOpenTag($code);
        $code = $this->compilePHPCloseTag($code);
        $code = $this->compileEchoTypes($code);
        $code = $this->compilePrintTypes($code);
        $code = $this->compileVarDumpTypes($code);
        $code = $this->compileVarExportTypes($code);
        $code = $this->compileSerializeTypes($code);
        $code = $this->compileUnserializeTypes($code);
        $code = $this->compileJsonEncode($code);
        $code = $this->compileJsonDecode($code);
        $code = $this->compileFileGetContents($code);
        $code = $this->compileFilePutContents($code);
        $code = $this->compileFopen($code);
        $code = $this->compileFclose($code);
        $code = $this->compileFread($code);
        $code = $this->compileFwrite($code);
        $code = $this->compileFseek($code);
        $code = $this->compileFtell($code);
        $code = $this->compileFeof($code);
        $code = $this->compileFgets($code);
        $code = $this->compileFgetcsv($code);
        $code = $this->compileFputcsv($code);
        $code = $this->compileFgetss($code);
        $code = $this->compileFpassthru($code);
        $code = $this->compileFflush($code);
        $code = $this->compileFlock($code);
        $code = $this->compileFtruncate($code);
        $code = $this->compileFstat($code);
        $code = $this->compileFseekEnd($code);
        $code = $this->compileFseekCurrent($code);
        $code = $this->compileFseekSet($code);
        $code = $this->compileDirectoryFunctions($code);
        $code = $this->compileDirectoryOpen($code);
        $code = $this->compileDirectoryRead($code);
        $code = $this->compileDirectoryClose($code);
        $code = $this->compileDirectoryRewind($code);
        $code = $this->compileScandir($code);
        $code = $this->compileDirname($code);
        $code = $this->compileBasename($code);
        $code = $this->compilePathinfo($code);
        $code = $this->compileRealpath($code);
        $code = $this->compileIsDir($code);
        $code = $this->compileIsFile($code);
        $code = $this->compileIsLink($code);
        $code = $this->compileIsReadable($code);
        $code = $this->compileIsWritable($code);
        $code = $this->compileIsExecutable($code);
        $code = $this->compileFileExists($code);
        $code = $this->compileFileSize($code);
        $code = $this->compileFileMtime($code);
        $code = $this->compileFileCtime($code);
        $code = $this->compileFileAtime($code);
        $code = $this->compileFileOwner($code);
        $code = $this->compileFileGroup($code);
        $code = $this->compileFilePerms($code);
        $code = $this->compileFileInode($code);
        $code = $this->compileFileType($code);
        $code = $this->compileCopy($code);
        $code = $this->compileMove($code);
        $code = $this->compileRename($code);
        $code = $this->compileDelete($code);
        $code = $this->compileUnlink($code);
        $code = $this->compileMkdir($code);
        $code = $this->compileRmdir($code);
        $code = $this->compileChmod($code);
        $code = $this->compileChown($code);
        $code = $this->compileChgrp($code);
        $code = $this->compileSymlink($code);
        $code = $this->compileReadlink($code);
        $code = $this->compileLinkinfo($code);
        $code = $this->compileLink($code);
        $code = $this->compileTouch($code);
        $code = $this->compileClearstatcache($code);
        $code = $this->compileDiskFreeSpace($code);
        $code = $this->compileDiskTotalSpace($code);
        $code = $this->compileGlob($code);
        $code = $this->compileTempnam($code);
        $code = $this->compileTmpfile($code);
        $code = $this->compileSysGetTempDir($code);
        $code = $this->compileStringFunctions($code);
        $code = $this->compileStrlen($code);
        $code = $this->compileStrpos($code);
        $code = $this->compileStripos($code);
        $code = $this->compileStrrpos($code);
        $code = $this->compileStrripos($code);
        $code = $this->compileSubstr($code);
        $code = $this->compileStrReplace($code);
        $code = $this->compileStrIreplace($code);
        $code = $this->compileStrtr($code);
        $code = $this->compileStrShuffle($code);
        $code = $this->compileStrrev($code);
        $code = $this->compileStrToLower($code);
        $code = $this->compileStrToUpper($code);
        $code = $this->compileUcfirst($code);
        $code = $this->compileUcwords($code);
        $code = $this->compileLcfirst($code);
        $code = $this->compileTrim($code);
        $code = $this->compileLtrim($code);
        $code = $this->compileRtrim($code);
        $code = $this->compileChop($code);
        $code = $this->compileChunkSplit($code);
        $code = $this->compileExplode($code);
        $code = $this->compileImplode($code);
        $code = $this->compileJoin($code);
        $code = $this->compileStrSplit($code);
        $code = $this->compileStrRepeat($code);
        $code = $this->compileWordwrap($code);
        $code = $this->compileNl2br($code);
        $code = $this->compileStripTags($code);
        $code = $this->compileHtmlentities($code);
        $code = $this->compileHtml_entity_decode($code);
        $code = $this->compileHtmlspecialchars($code);
        $code = $this->compileHtmlspecialchars_decode($code);
        $code = $this->compileAddslashes($code);
        $code = $this->compileStripslashes($code);
        $code = $this->compileQuotemeta($code);
        $code = $this->compileStripcslashes($code);
        $code = $this->compileAddcslashes($code);
        $code = $this->compileParseStr($code);
        $code = $this->compileStrPad($code);
        $code = $this->compileStrColl($code);
        $code = $this->compileSubstrCount($code);
        $code = $this->compileStrCasecmp($code);
        $code = $this->compileStrnatcmp($code);
        $code = $this->compileStrnatcasecmp($code);
        $code = $this->compileStrncmp($code);
        $code = $this->compileStrncasecmp($code);
        $code = $this->compileStrcmp($code);
        $code = $this->compileStrstr($code);
        $code = $this->compileStristr($code);
        $code = $this->compileStrrchr($code);
        $code = $this->compileSubstrReplace($code);
        $code = $this->compileStrIreplaceArray($code);
        $code = $this->compileStrReplaceArray($code);
        $code = $this->compileStrposArray($code);
        $code = $this->compileStriposArray($code);
        $code = $this->compileStrrposArray($code);
        $code = $this->compileStrriposArray($code);
        $code = $this->compileSubstrCompare($code);
        $code = $this->compileStrptime($code);
        $code = $this->compileStrftime($code);
        $code = $this->compileGmstrftime($code);
        $code = $this->compileDateFunctions($code);
        $code = $this->compileDate($code);
        $code = $this->compileGmdate($code);
        $code = $this->compileTime($code);
        $code = $this->compileMicrotime($code);
        $code = $this->compileMktime($code);
        $code = $this->compileGmmktime($code);
        $code = $this->compileStrToTime($code);
        $code = $this->compileStrToTimeSafe($code);
        $code = $this->compileDateDefaultTimezoneSet($code);
        $code = $this->compileDateDefaultTimezoneGet($code);
        $code = $this->compileDateSunrise($code);
        $code = $this->compileDateSunset($code);
        $code = $this->compileDateParse($code);
        $code = $this->compileDateParseFromFormat($code);
        $code = $this->compileDateCreate($code);
        $code = $this->compileDateCreateFromFormat($code);
        $code = $this->compileDateGetLastErrors($code);
        $code = $this->compileDateTimeClass($code);
        $code = $this->compileDateTimeInterface($code);
        $code = $this->compileDateTimeImmutable($code);
        $code = $this->compileDateInterval($code);
        $code = $this->compileDatePeriod($code);
        $code = $this->compileDateTimeZone($code);
        $code = $this->compileTimeZoneOpen($code);
        $code = $this->compileTimeZoneName($code);
        $code = $this->compileTimeZoneIdentifiersList($code);
        $code = $this->compileTimeZoneLocationGet($code);
        $code = $this->compileTimeZoneTransitions($code);
        $code = $this->compileTimeZoneOffset($code);
        $code = $this->compileDateTimeDiff($code);
        $code = $this->compileDateTimeAdd($code);
        $code = $this->compileDateTimeSub($code);
        $code = $this->compileDateTimeModify($code);
        $code = $this->compileDateTimeSetDate($code);
        $code = $this->compileDateTimeSetISODate($code);
        $code = $this->compileDateTimeSetTime($code);
        $code = $this->compileDateTimeSetTimestamp($code);
        $code = $this->compileDateTimeGetTimestamp($code);
        $code = $this->compileDateTimeFormat($code);
        $code = $this->compileDateTimeGetOffset($code);
        $code = $this->compileDateTimeGetTimeZone($code);
        $code = $this->compileDateTimeSetTimeZone($code);
        $code = $this->compileDateTimeCreateFromImmutable($code);
        $code = $this->compileDateTimeImmutableCreateFromMutable($code);
        $code = $this->compileDateIntervalCreateFromDateString($code);
        $code = $this->compileDateIntervalFormat($code);
        $code = $this->compileDatePeriodGetDateInterval($code);
        $code = $this->compileDatePeriodGetEndDate($code);
        $code = $this->compileDatePeriodGetStartDate($code);
        $code = $this->compileDatePeriodGetRecurrences($code);
        $code = $this->compileDateTimeGetLastErrors($code);
        $code = $this->compileDateTimeWarnings($code);
        $code = $this->compileDateTimeErrors($code);

        return $code;
    }

    private function removeDollarSign(string $code): string
    {
        return preg_replace(
            '/(?<![->])[$]([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/',
            '$1',
            $code
        ) ?? $code;
    }

    private function replaceKeywords(string $code): string
    {
        foreach ($this->keywords as $xl => $php) {
            $code = preg_replace(
                '/\b' . preg_quote($xl, '/') . '\b/',
                $php,
                $code
            ) ?? $code;
        }
        return $code;
    }

    private function compileShortFunctions(string $code): string
    {
        return preg_replace(
            '/func\s+(\w+)\s*\(([^)]*)\)\s*=>\s*([^;]+);/',
            'function $1($2) { return $3; }',
            $code
        ) ?? $code;
    }

    private function compileObjectCreation(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\(\)/',
            'new $1()',
            $code
        ) ?? $code;
    }

    private function compileForLoops(string $code): string
    {
        return preg_replace(
            '/loop\s+(\w+)\s+in\s+([^{]+){/',
            'foreach ($2 as $1) {',
            $code
        ) ?? $code;
    }

    private function compileStringInterpolation(string $code): string
    {
        return preg_replace(
            '/\{([^}]+)\}/',
            '" . $1 . "',
            $code
        ) ?? $code;
    }

    private function compileArrayShortSyntax(string $code): string
    {
        return preg_replace(
            '/\[([^\]]*)\]/',
            'array($1)',
            $code
        ) ?? $code;
    }

    private function compileWhileLoops(string $code): string
    {
        return preg_replace(
            '/while\s+([^{]+){/',
            'while ($1) {',
            $code
        ) ?? $code;
    }

    private function compileSwitchStatement(string $code): string
    {
        return preg_replace(
            '/select\s+([^{]+){/',
            'switch ($1) {',
            $code
        ) ?? $code;
    }

    private function compileTernaryOperator(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\?\s*([^:;]+)\s*:\s*([^;]+)/',
            '($1 ? $2 : $3)',
            $code
        ) ?? $code;
    }

    private function compileNullCoalesce(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\?\?\s*([^;]+)/',
            '($1 ?? $2)',
            $code
        ) ?? $code;
    }

    private function compileArrowFunctions(string $code): string
    {
        return preg_replace(
            '/fn\s+\(([^)]*)\)\s*=>\s*([^;]+)/',
            'function($1) { return $2; }',
            $code
        ) ?? $code;
    }

    private function compilePropertyAccess(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\.\s*(\w+)/',
            '$1->$2',
            $code
        ) ?? $code;
    }

    private function compileMethodCalls(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\.\s*(\w+)\s*\(/',
            '$1->$2(',
            $code
        ) ?? $code;
    }

    private function compileStaticCalls(string $code): string
    {
        return preg_replace(
            '/(\w+)::(\w+)/',
            '$1::$2',
            $code
        ) ?? $code;
    }

    private function compileNamespaces(string $code): string
    {
        return preg_replace(
            '/namespace\s+([^{;]+)/',
            'namespace $1',
            $code
        ) ?? $code;
    }

    private function compileUseStatements(string $code): string
    {
        return preg_replace(
            '/use\s+([^;]+)/',
            'use $1',
            $code
        ) ?? $code;
    }

    private function compileTraits(string $code): string
    {
        return preg_replace(
            '/trait\s+(\w+)/',
            'trait $1',
            $code
        ) ?? $code;
    }

    private function compileInterfaces(string $code): string
    {
        return preg_replace(
            '/interface\s+(\w+)/',
            'interface $1',
            $code
        ) ?? $code;
    }

    private function compileAbstractClasses(string $code): string
    {
        return preg_replace(
            '/abstract\s+type\s+(\w+)/',
            'abstract class $1',
            $code
        ) ?? $code;
    }

    private function compileFinalClasses(string $code): string
    {
        return preg_replace(
            '/final\s+type\s+(\w+)/',
            'final class $1',
            $code
        ) ?? $code;
    }

    private function compileConstants(string $code): string
    {
        return preg_replace(
            '/const\s+(\w+)\s*=\s*([^;]+)/',
            'const $1 = $2',
            $code
        ) ?? $code;
    }

    private function compileEnumClasses(string $code): string
    {
        return preg_replace(
            '/enum\s+(\w+)/',
            'enum $1',
            $code
        ) ?? $code;
    }

    private function compileMatchExpression(string $code): string
    {
        return preg_replace(
            '/match\s+\(([^)]+)\)\s*{([^}]*)}/',
            'match ($1) { $2 }',
            $code
        ) ?? $code;
    }

    private function compileAttributes(string $code): string
    {
        return preg_replace(
            '/#\[([^\]]+)\]/',
            '#[$1]',
            $code
        ) ?? $code;
    }

    private function compileConstructorPropertyPromotion(string $code): string
    {
        return preg_replace(
            '/\b(public|private|protected)\s+(\w+)\s+(\w+)/',
            '$1 $2 $3',
            $code
        ) ?? $code;
    }

    private function compileNamedArguments(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*:\s*([^,)]+)/',
            '$1: $2',
            $code
        ) ?? $code;
    }

    private function compileUnionTypes(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*\|\s*(\w+)/',
            '$1|$2',
            $code
        ) ?? $code;
    }

    private function compileIntersectionTypes(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*&&\s*(\w+)/',
            '$1&$2',
            $code
        ) ?? $code;
    }

    private function compileMixedType(string $code): string
    {
        return preg_replace(
            '/\bmixed\b/',
            'mixed',
            $code
        ) ?? $code;
    }

    private function compileVoidType(string $code): string
    {
        return preg_replace(
            '/\bvoid\b/',
            'void',
            $code
        ) ?? $code;
    }

    private function compileNeverType(string $code): string
    {
        return preg_replace(
            '/\bnever\b/',
            'never',
            $code
        ) ?? $code;
    }

    private function compileStaticType(string $code): string
    {
        return preg_replace(
            '/\bstatic\b/',
            'static',
            $code
        ) ?? $code;
    }

    private function compileIterableType(string $code): string
    {
        return preg_replace(
            '/\biterable\b/',
            'iterable',
            $code
        ) ?? $code;
    }

    private function compileCallableType(string $code): string
    {
        return preg_replace(
            '/\bcallable\b/',
            'callable',
            $code
        ) ?? $code;
    }

    private function compileObjectType(string $code): string
    {
        return preg_replace(
            '/\bobject\b/',
            'object',
            $code
        ) ?? $code;
    }

    private function compileArrayDestructuring(string $code): string
    {
        return preg_replace(
            '/\[([^\]]+)\]\s*=\s*([^;]+)/',
            'list($1) = $2',
            $code
        ) ?? $code;
    }

    private function compileSpreadOperator(string $code): string
    {
        return preg_replace(
            '/\.\.\.([a-zA-Z_][a-zA-Z0-9_]*)/',
            '...$1',
            $code
        ) ?? $code;
    }

    private function compileVariadicFunctions(string $code): string
    {
        return preg_replace(
            '/func\s+(\w+)\s*\(\.\.\.\s*(\w+)\)/',
            'function $1(...$2)',
            $code
        ) ?? $code;
    }

    private function compileGeneratorFunctions(string $code): string
    {
        return preg_replace(
            '/func\s+(\w+)\s*\(([^)]*)\)\s*yield\s+([^;]+)/',
            'function $1($2) { yield $3; }',
            $code
        ) ?? $code;
    }

    private function compileYieldFrom(string $code): string
    {
        return preg_replace(
            '/yield\s+from\s+([^;]+)/',
            'yield from $1',
            $code
        ) ?? $code;
    }

    private function compileFinallyBlocks(string $code): string
    {
        return preg_replace(
            '/finally\s*{/',
            'finally {',
            $code
        ) ?? $code;
    }

    private function compileThrowExpression(string $code): string
    {
        return preg_replace(
            '/throw\s+([^;]+)/',
            'throw $1',
            $code
        ) ?? $code;
    }

    private function compileMatchAsExpression(string $code): string
    {
        return preg_replace(
            '/match\s+\(([^)]+)\)\s*=>\s*([^;]+)/',
            'match($1) { default => $2 }',
            $code
        ) ?? $code;
    }

    private function compileReadonlyProperties(string $code): string
    {
        return preg_replace(
            '/\breadonly\b/',
            'readonly',
            $code
        ) ?? $code;
    }

    private function compileReadonlyClasses(string $code): string
    {
        return preg_replace(
            '/readonly\s+type\s+(\w+)/',
            'readonly class $1',
            $code
        ) ?? $code;
    }

    private function compileTypedProperties(string $code): string
    {
        return preg_replace(
            '/(public|private|protected)\s+(\w+)\s+(\w+)/',
            '$1 $2 $3',
            $code
        ) ?? $code;
    }

    private function compileNullableTypes(string $code): string
    {
        return preg_replace(
            '/\?(\w+)/',
            '?$1',
            $code
        ) ?? $code;
    }

    private function compileArrayShapeSyntax(string $code): string
    {
        return preg_replace(
            '/array\s*\{([^}]*)\}/',
            'array{$1}',
            $code
        ) ?? $code;
    }

    private function compileListSyntax(string $code): string
    {
        return preg_replace(
            '/list\s*\(([^)]+)\)\s*=\s*([^;]+)/',
            'list($1) = $2',
            $code
        ) ?? $code;
    }

    private function compileArrayUnpacking(string $code): string
    {
        return preg_replace(
            '/\.\.\.([a-zA-Z_][a-zA-Z0-9_]*)\s*in\s+array/',
            '...$1',
            $code
        ) ?? $code;
    }

    private function compileStringableInterface(string $code): string
    {
        return preg_replace(
            '/\bStringable\b/',
            'Stringable',
            $code
        ) ?? $code;
    }

    private function compileWeakMaps(string $code): string
    {
        return preg_replace(
            '/WeakMap\s*\{/',
            'WeakMap {',
            $code
        ) ?? $code;
    }

    private function compileFiberSupport(string $code): string
    {
        return preg_replace(
            '/Fiber\s*\{/',
            'Fiber {',
            $code
        ) ?? $code;
    }

    private function compileSensitiveParameters(string $code): string
    {
        return preg_replace(
            '/#\[SensitiveParameter\]/',
            '#[SensitiveParameter]',
            $code
        ) ?? $code;
    }

    private function compileAsymmetricVisibility(string $code): string
    {
        return preg_replace(
            '/(public|private|protected)\s+\(\s*(public|private|protected)\s+\)/',
            '$1($2)',
            $code
        ) ?? $code;
    }

    private function compileEnumBacked(string $code): string
    {
        return preg_replace(
            '/enum\s+(\w+)\s*:\s*(\w+)/',
            'enum $1: $2',
            $code
        ) ?? $code;
    }

    private function compileEnumCases(string $code): string
    {
        return preg_replace(
            '/case\s+(\w+)\s*=\s*([^;]+)/',
            'case $1 = $2',
            $code
        ) ?? $code;
    }

    private function compileEnumMethods(string $code): string
    {
        return preg_replace(
            '/func\s+(\w+)\s*\(([^)]*)\)\s*{/',
            'function $1($2) {',
            $code
        ) ?? $code;
    }

    private function compileEnumConstants(string $code): string
    {
        return preg_replace(
            '/const\s+(\w+)\s*=\s*([^;]+)/',
            'const $1 = $2',
            $code
        ) ?? $code;
    }

    private function compileEnumTraitUsage(string $code): string
    {
        return preg_replace(
            '/use\s+([^;]+);/',
            'use $1;',
            $code
        ) ?? $code;
    }

    private function compileNewInitializers(string $code): string
    {
        return preg_replace(
            '/new\s+(\w+)\s*\(\s*\)/',
            'new $1()',
            $code
        ) ?? $code;
    }

    private function compilePropertyHooks(string $code): string
    {
        return preg_replace(
            '/get\s*{/',
            'get {',
            $code
        ) ?? $code;
    }

    private function compileLazyObjects(string $code): string
    {
        return preg_replace(
            '/lazy\s+(\w+)/',
            'lazy $1',
            $code
        ) ?? $code;
    }

    private function compileFirstClassCallable(string $code): string
    {
        return preg_replace(
            '/(\w+)\.\.\./',
            '$1(...)',
            $code
        ) ?? $code;
    }

    private function compileArrayIsList(string $code): string
    {
        return preg_replace(
            '/array_is_list\s*\(([^)]+)\)/',
            'array_is_list($1)',
            $code
        ) ?? $code;
    }

    private function compileErrorBacktrace(string $code): string
    {
        return preg_replace(
            '/debug_backtrace\s*\(/',
            'debug_backtrace(',
            $code
        ) ?? $code;
    }

    private function compileDeprecations(string $code): string
    {
        return preg_replace(
            '/#\[Deprecated\]/',
            '#[Deprecated]',
            $code
        ) ?? $code;
    }

    private function compileAttributeSyntax(string $code): string
    {
        return preg_replace(
            '/#\[([^\]]+)\]/',
            '#[$1]',
            $code
        ) ?? $code;
    }

    private function compileClassConstantType(string $code): string
    {
        return preg_replace(
            '/const\s+(\w+)\s*:\s*(\w+)\s*=\s*([^;]+)/',
            'const $1: $2 = $3',
            $code
        ) ?? $code;
    }

    private function compileFunctionConstantType(string $code): string
    {
        return preg_replace(
            '/const\s+(\w+)\s*:\s*(\w+)\s*=\s*([^;]+)/',
            'const $1: $2 = $3',
            $code
        ) ?? $code;
    }

    private function compilePropertyConstantType(string $code): string
    {
        return preg_replace(
            '/const\s+(\w+)\s*:\s*(\w+)\s*=\s*([^;]+)/',
            'const $1: $2 = $3',
            $code
        ) ?? $code;
    }

    private function compileTrueFalseNull(string $code): string
    {
        return preg_replace(
            '/\b(yes|no|null)\b/',
            '$1',
            $code
        ) ?? $code;
    }

    private function compileMatchCondition(string $code): string
    {
        return preg_replace(
            '/match\s+\(([^)]+)\)\s*{/',
            'match ($1) {',
            $code
        ) ?? $code;
    }

    private function compileDefaultMatch(string $code): string
    {
        return preg_replace(
            '/default\s*=>\s*([^,}]+)/',
            'default => $1',
            $code
        ) ?? $code;
    }

    private function compileNamedParameters(string $code): string
    {
        return preg_replace(
            '/(\w+)\s*:\s*([^,)]+)/',
            '$1: $2',
            $code
        ) ?? $code;
    }

    private function compileArgumentUnpacking(string $code): string
    {
        return preg_replace(
            '/\.\.\.([a-zA-Z_][a-zA-Z0-9_]*)/',
            '...$1',
            $code
        ) ?? $code;
    }

    private function compileAnonymousClasses(string $code): string
    {
        return preg_replace(
            '/new\s+class\s*{/',
            'new class {',
            $code
        ) ?? $code;
    }

    private function compileAnonymousFunctions(string $code): string
    {
        return preg_replace(
            '/func\s*\(([^)]*)\)\s*=>\s*([^;]+)/',
            'function($1) { return $2; }',
            $code
        ) ?? $code;
    }

    private function compileClosures(string $code): string
    {
        return preg_replace(
            '/func\s*\(([^)]*)\)\s*{/',
            'function($1) {',
            $code
        ) ?? $code;
    }

    private function compileCallableTypes(string $code): string
    {
        return preg_replace(
            '/\bcallable\b/',
            'callable',
            $code
        ) ?? $code;
    }

    private function compileIterableTypes(string $code): string
    {
        return preg_replace(
            '/\biterable\b/',
            'iterable',
            $code
        ) ?? $code;
    }

    private function compileMixedTypes(string $code): string
    {
        return preg_replace(
            '/\bmixed\b/',
            'mixed',
            $code
        ) ?? $code;
    }

    private function compileVoidTypes(string $code): string
    {
        return preg_replace(
            '/\bvoid\b/',
            'void',
            $code
        ) ?? $code;
    }

    private function compileNeverTypes(string $code): string
    {
        return preg_replace(
            '/\bnever\b/',
            'never',
            $code
        ) ?? $code;
    }

    private function compileStaticTypes(string $code): string
    {
        return preg_replace(
            '/\bstatic\b/',
            'static',
            $code
        ) ?? $code;
    }

    private function compileIterableTypesAdvanced(string $code): string
    {
        return preg_replace(
            '/\biterable\b/',
            'iterable',
            $code
        ) ?? $code;
    }

    private function compileCallableTypesAdvanced(string $code): string
    {
        return preg_replace(
            '/\bcallable\b/',
            'callable',
            $code
        ) ?? $code;
    }

    private function compileObjectTypes(string $code): string
    {
        return preg_replace(
            '/\bobject\b/',
            'object',
            $code
        ) ?? $code;
    }

    private function compileArrayTypes(string $code): string
    {
        return preg_replace(
            '/\barray\b/',
            'array',
            $code
        ) ?? $code;
    }

    private function compileStringTypes(string $code): string
    {
        return preg_replace(
            '/\bstring\b/',
            'string',
            $code
        ) ?? $code;
    }

    private function compileIntTypes(string $code): string
    {
        return preg_replace(
            '/\bint\b/',
            'int',
            $code
        ) ?? $code;
    }

    private function compileFloatTypes(string $code): string
    {
        return preg_replace(
            '/\bfloat\b/',
            'float',
            $code
        ) ?? $code;
    }

    private function compileBoolTypes(string $code): string
    {
        return preg_replace(
            '/\bbool\b/',
            'bool',
            $code
        ) ?? $code;
    }

    private function compileResourceTypes(string $code): string
    {
        return preg_replace(
            '/\bresource\b/',
            'resource',
            $code
        ) ?? $code;
    }

    private function compileNullTypes(string $code): string
    {
        return preg_replace(
            '/\bnull\b/',
            'null',
            $code
        ) ?? $code;
    }

    private function compileScalarTypes(string $code): string
    {
        return preg_replace(
            '/\bscalar\b/',
            'scalar',
            $code
        ) ?? $code;
    }

    private function compileClassTypes(string $code): string
    {
        return preg_replace(
            '/\bclass\b/',
            'class',
            $code
        ) ?? $code;
    }

    private function compileInterfaceTypes(string $code): string
    {
        return preg_replace(
            '/\binterface\b/',
            'interface',
            $code
        ) ?? $code;
    }

    private function compileTraitTypes(string $code): string
    {
        return preg_replace(
            '/\btrait\b/',
            'trait',
            $code
        ) ?? $code;
    }

    private function compileEnumTypes(string $code): string
    {
        return preg_replace(
            '/\benum\b/',
            'enum',
            $code
        ) ?? $code;
    }

    private function compileFunctionTypes(string $code): string
    {
        return preg_replace(
            '/\bfunction\b/',
            'function',
            $code
        ) ?? $code;
    }

    private function compileMethodTypes(string $code): string
    {
        return preg_replace(
            '/\bmethod\b/',
            'method',
            $code
        ) ?? $code;
    }

    private function compilePropertyTypes(string $code): string
    {
        return preg_replace(
            '/\bproperty\b/',
            'property',
            $code
        ) ?? $code;
    }

    private function compileConstantTypes(string $code): string
    {
        return preg_replace(
            '/\bconst\b/',
            'const',
            $code
        ) ?? $code;
    }

    private function compileVariableTypes(string $code): string
    {
        return preg_replace(
            '/\bvar\b/',
            'var',
            $code
        ) ?? $code;
    }

    private function compileExpressionTypes(string $code): string
    {
        return preg_replace(
            '/\bexpr\b/',
            'expr',
            $code
        ) ?? $code;
    }

    private function compileStatementTypes(string $code): string
    {
        return preg_replace(
            '/\bstmt\b/',
            'stmt',
            $code
        ) ?? $code;
    }

    private function compileBlockTypes(string $code): string
    {
        return preg_replace(
            '/\bblock\b/',
            'block',
            $code
        ) ?? $code;
    }

    private function compileFileTypes(string $code): string
    {
        return preg_replace(
            '/\bfile\b/',
            'file',
            $code
        ) ?? $code;
    }

    private function compileNamespaceTypes(string $code): string
    {
        return preg_replace(
            '/\bnamespace\b/',
            'namespace',
            $code
        ) ?? $code;
    }

    private function compileUseTypes(string $code): string
    {
        return preg_replace(
            '/\buse\b/',
            'use',
            $code
        ) ?? $code;
    }

    private function compileImportTypes(string $code): string
    {
        return preg_replace(
            '/\bimport\b/',
            'import',
            $code
        ) ?? $code;
    }

    private function compileExportTypes(string $code): string
    {
        return preg_replace(
            '/\bexport\b/',
            'export',
            $code
        ) ?? $code;
    }

    private function compileIncludeTypes(string $code): string
    {
        return preg_replace(
            '/\binclude\b/',
            'include',
            $code
        ) ?? $code;
    }

    private function compileRequireTypes(string $code): string
    {
        return preg_replace(
            '/\brequire\b/',
            'require',
            $code
        ) ?? $code;
    }

    private function compileOnceTypes(string $code): string
    {
        return preg_replace(
            '/\bonce\b/',
            'once',
            $code
        ) ?? $code;
    }

    private function compileGlobalTypes(string $code): string
    {
        return preg_replace(
            '/\bglobal\b/',
            'global',
            $code
        ) ?? $code;
    }

    private function compileStaticTypesAdvanced(string $code): string
    {
        return preg_replace(
            '/\bstatic\b/',
            'static',
            $code
        ) ?? $code;
    }

    private function compileSelfTypes(string $code): string
    {
        return preg_replace(
            '/\bself\b/',
            'self',
            $code
        ) ?? $code;
    }

    private function compileParentTypes(string $code): string
    {
        return preg_replace(
            '/\bparent\b/',
            'parent',
            $code
        ) ?? $code;
    }

    private function compileThisTypes(string $code): string
    {
        return preg_replace(
            '/\bthis\b/',
            '$this',
            $code
        ) ?? $code;
    }

    private function compileYieldTypes(string $code): string
    {
        return preg_replace(
            '/\byield\b/',
            'yield',
            $code
        ) ?? $code;
    }

    private function compileReturnTypes(string $code): string
    {
        return preg_replace(
            '/\breturn\b/',
            'return',
            $code
        ) ?? $code;
    }

    private function compileThrowTypes(string $code): string
    {
        return preg_replace(
            '/\bthrow\b/',
            'throw',
            $code
        ) ?? $code;
    }

    private function compileCatchTypes(string $code): string
    {
        return preg_replace(
            '/\bcatch\b/',
            'catch',
            $code
        ) ?? $code;
    }

    private function compileFinallyTypes(string $code): string
    {
        return preg_replace(
            '/\bfinally\b/',
            'finally',
            $code
        ) ?? $code;
    }

    private function compileTryTypes(string $code): string
    {
        return preg_replace(
            '/\btry\b/',
            'try',
            $code
        ) ?? $code;
    }

    private function compileIfTypes(string $code): string
    {
        return preg_replace(
            '/\bif\b/',
            'if',
            $code
        ) ?? $code;
    }

    private function compileElseTypes(string $code): string
    {
        return preg_replace(
            '/\belse\b/',
            'else',
            $code
        ) ?? $code;
    }

    private function compileElseIfTypes(string $code): string
    {
        return preg_replace(
            '/\belseif\b/',
            'elseif',
            $code
        ) ?? $code;
    }

    private function compileWhileTypes(string $code): string
    {
        return preg_replace(
            '/\bwhile\b/',
            'while',
            $code
        ) ?? $code;
    }

    private function compileDoWhileTypes(string $code): string
    {
        return preg_replace(
            '/\bdo\s+while\b/',
            'do while',
            $code
        ) ?? $code;
    }

    private function compileForTypes(string $code): string
    {
        return preg_replace(
            '/\bfor\b/',
            'for',
            $code
        ) ?? $code;
    }

    private function compileForeachTypes(string $code): string
    {
        return preg_replace(
            '/\bforeach\b/',
            'foreach',
            $code
        ) ?? $code;
    }

    private function compileSwitchTypes(string $code): string
    {
        return preg_replace(
            '/\bswitch\b/',
            'switch',
            $code
        ) ?? $code;
    }

    private function compileCaseTypes(string $code): string
    {
        return preg_replace(
            '/\bcase\b/',
            'case',
            $code
        ) ?? $code;
    }

    private function compileDefaultTypes(string $code): string
    {
        return preg_replace(
            '/\bdefault\b/',
            'default',
            $code
        ) ?? $code;
    }

    private function compileBreakTypes(string $code): string
    {
        return preg_replace(
            '/\bbreak\b/',
            'break',
            $code
        ) ?? $code;
    }

    private function compileContinueTypes(string $code): string
    {
        return preg_replace(
            '/\bcontinue\b/',
            'continue',
            $code
        ) ?? $code;
    }

    private function compileExitTypes(string $code): string
    {
        return preg_replace(
            '/\bexit\b/',
            'exit',
            $code
        ) ?? $code;
    }

    private function compileDieTypes(string $code): string
    {
        return preg_replace(
            '/\bdie\b/',
            'die',
            $code
        ) ?? $code;
    }

    private function compileEvalTypes(string $code): string
    {
        return preg_replace(
            '/\beval\b/',
            'eval',
            $code
        ) ?? $code;
    }

    private function compileSystemTypes(string $code): string
    {
        return preg_replace(
            '/\bsystem\b/',
            'system',
            $code
        ) ?? $code;
    }

    private function compileExecTypes(string $code): string
    {
        return preg_replace(
            '/\bexec\b/',
            'exec',
            $code
        ) ?? $code;
    }

    private function compilePassthruTypes(string $code): string
    {
        return preg_replace(
            '/\bpassthru\b/',
            'passthru',
            $code
        ) ?? $code;
    }

    private function compileShellExecTypes(string $code): string
    {
        return preg_replace(
            '/\bshell_exec\b/',
            'shell_exec',
            $code
        ) ?? $code;
    }

    private function compileBacktickTypes(string $code): string
    {
        return preg_replace(
            '/`([^`]+)`/',
            'shell_exec("$1")',
            $code
        ) ?? $code;
    }

    private function compilePHPOpenTag(string $code): string
    {
        return preg_replace(
            '/<\?xlphp/',
            '<?php',
            $code
        ) ?? $code;
    }

    private function compilePHPCloseTag(string $code): string
    {
        return preg_replace(
            '/\?>/',
            '?>',
            $code
        ) ?? $code;
    }

    private function compileEchoTypes(string $code): string
    {
        return preg_replace(
            '/\becho\b/',
            'echo',
            $code
        ) ?? $code;
    }

    private function compilePrintTypes(string $code): string
    {
        return preg_replace(
            '/\bprint\b/',
            'print',
            $code
        ) ?? $code;
    }

    private function compileVarDumpTypes(string $code): string
    {
        return preg_replace(
            '/\bvar_dump\b/',
            'var_dump',
            $code
        ) ?? $code;
    }

    private function compileVarExportTypes(string $code): string
    {
        return preg_replace(
            '/\bvar_export\b/',
            'var_export',
            $code
        ) ?? $code;
    }

    private function compileSerializeTypes(string $code): string
    {
        return preg_replace(
            '/\bserialize\b/',
            'serialize',
            $code
        ) ?? $code;
    }

    private function compileUnserializeTypes(string $code): string
    {
        return preg_replace(
            '/\bunserialize\b/',
            'unserialize',
            $code
        ) ?? $code;
    }

    private function compileJsonEncode(string $code): string
    {
        return preg_replace(
            '/\bjson_encode\b/',
            'json_encode',
            $code
        ) ?? $code;
    }

    private function compileJsonDecode(string $code): string
    {
        return preg_replace(
            '/\bjson_decode\b/',
            'json_decode',
            $code
        ) ?? $code;
    }

    private function compileFileGetContents(string $code): string
    {
        return preg_replace(
            '/\bfile_get_contents\b/',
            'file_get_contents',
            $code
        ) ?? $code;
    }

    private function compileFilePutContents(string $code): string
    {
        return preg_replace(
            '/\bfile_put_contents\b/',
            'file_put_contents',
            $code
        ) ?? $code;
    }

    private function compileFopen(string $code): string
    {
        return preg_replace(
            '/\bfopen\b/',
            'fopen',
            $code
        ) ?? $code;
    }

    private function compileFclose(string $code): string
    {
        return preg_replace(
            '/\bfclose\b/',
            'fclose',
            $code
        ) ?? $code;
    }

    private function compileFread(string $code): string
    {
        return preg_replace(
            '/\bfread\b/',
            'fread',
            $code
        ) ?? $code;
    }

    private function compileFwrite(string $code): string
    {
        return preg_replace(
            '/\bfwrite\b/',
            'fwrite',
            $code
        ) ?? $code;
    }

    private function compileFseek(string $code): string
    {
        return preg_replace(
            '/\bfseek\b/',
            'fseek',
            $code
        ) ?? $code;
    }

    private function compileFtell(string $code): string
    {
        return preg_replace(
            '/\bftell\b/',
            'ftell',
            $code
        ) ?? $code;
    }

    private function compileFeof(string $code): string
    {
        return preg_replace(
            '/\bfeof\b/',
            'feof',
            $code
        ) ?? $code;
    }

    private function compileFgets(string $code): string
    {
        return preg_replace(
            '/\bfgets\b/',
            'fgets',
            $code
        ) ?? $code;
    }

    private function compileFgetcsv(string $code): string
    {
        return preg_replace(
            '/\bfgetcsv\b/',
            'fgetcsv',
            $code
        ) ?? $code;
    }

    private function compileFputcsv(string $code): string
    {
        return preg_replace(
            '/\bfputcsv\b/',
            'fputcsv',
            $code
        ) ?? $code;
    }

    private function compileFgetss(string $code): string
    {
        return preg_replace(
            '/\bfgetss\b/',
            'fgetss',
            $code
        ) ?? $code;
    }

    private function compileFpassthru(string $code): string
    {
        return preg_replace(
            '/\bfpassthru\b/',
            'fpassthru',
            $code
        ) ?? $code;
    }

    private function compileFflush(string $code): string
    {
        return preg_replace(
            '/\bfflush\b/',
            'fflush',
            $code
        ) ?? $code;
    }

    private function compileFlock(string $code): string
    {
        return preg_replace(
            '/\bflock\b/',
            'flock',
            $code
        ) ?? $code;
    }

    private function compileFtruncate(string $code): string
    {
        return preg_replace(
            '/\bftruncate\b/',
            'ftruncate',
            $code
        ) ?? $code;
    }

    private function compileFstat(string $code): string
    {
        return preg_replace(
            '/\bfstat\b/',
            'fstat',
            $code
        ) ?? $code;
    }

    private function compileFseekEnd(string $code): string
    {
        return preg_replace(
            '/\bSEEK_END\b/',
            'SEEK_END',
            $code
        ) ?? $code;
    }

    private function compileFseekCurrent(string $code): string
    {
        return preg_replace(
            '/\bSEEK_CUR\b/',
            'SEEK_CUR',
            $code
        ) ?? $code;
    }

    private function compileFseekSet(string $code): string
    {
        return preg_replace(
            '/\bSEEK_SET\b/',
            'SEEK_SET',
            $code
        ) ?? $code;
    }

    private function compileDirectoryFunctions(string $code): string
    {
        return preg_replace(
            '/\bdirectory\b/',
            'directory',
            $code
        ) ?? $code;
    }

    private function compileDirectoryOpen(string $code): string
    {
        return preg_replace(
            '/\bopendir\b/',
            'opendir',
            $code
        ) ?? $code;
    }

    private function compileDirectoryRead(string $code): string
    {
        return preg_replace(
            '/\breaddir\b/',
            'readdir',
            $code
        ) ?? $code;
    }

    private function compileDirectoryClose(string $code): string
    {
        return preg_replace(
            '/\bclosedir\b/',
            'closedir',
            $code
        ) ?? $code;
    }

    private function compileDirectoryRewind(string $code): string
    {
        return preg_replace(
            '/\brewinddir\b/',
            'rewinddir',
            $code
        ) ?? $code;
    }

    private function compileScandir(string $code): string
    {
        return preg_replace(
            '/\bscandir\b/',
            'scandir',
            $code
        ) ?? $code;
    }

    private function compileDirname(string $code): string
    {
        return preg_replace(
            '/\bdirname\b/',
            'dirname',
            $code
        ) ?? $code;
    }

    private function compileBasename(string $code): string
    {
        return preg_replace(
            '/\bbasename\b/',
            'basename',
            $code
        ) ?? $code;
    }

    private function compilePathinfo(string $code): string
    {
        return preg_replace(
            '/\bpathinfo\b/',
            'pathinfo',
            $code
        ) ?? $code;
    }

    private function compileRealpath(string $code): string
    {
        return preg_replace(
            '/\brealpath\b/',
            'realpath',
            $code
        ) ?? $code;
    }

    private function compileIsDir(string $code): string
    {
        return preg_replace(
            '/\bis_dir\b/',
            'is_dir',
            $code
        ) ?? $code;
    }

    private function compileIsFile(string $code): string
    {
        return preg_replace(
            '/\bis_file\b/',
            'is_file',
            $code
        ) ?? $code;
    }

    private function compileIsLink(string $code): string
    {
        return preg_replace(
            '/\bis_link\b/',
            'is_link',
            $code
        ) ?? $code;
    }

    private function compileIsReadable(string $code): string
    {
        return preg_replace(
            '/\bis_readable\b/',
            'is_readable',
            $code
        ) ?? $code;
    }

    private function compileIsWritable(string $code): string
    {
        return preg_replace(
            '/\bis_writable\b/',
            'is_writable',
            $code
        ) ?? $code;
    }

    private function compileIsExecutable(string $code): string
    {
        return preg_replace(
            '/\bis_executable\b/',
            'is_executable',
            $code
        ) ?? $code;
    }

    private function compileFileExists(string $code): string
    {
        return preg_replace(
            '/\bfile_exists\b/',
            'file_exists',
            $code
        ) ?? $code;
    }

    private function compileFileSize(string $code): string
    {
        return preg_replace(
            '/\bfilesize\b/',
            'filesize',
            $code
        ) ?? $code;
    }

    private function compileFileMtime(string $code): string
    {
        return preg_replace(
            '/\bfilemtime\b/',
            'filemtime',
            $code
        ) ?? $code;
    }

    private function compileFileCtime(string $code): string
    {
        return preg_replace(
            '/\bfilectime\b/',
            'filectime',
            $code
        ) ?? $code;
    }

    private function compileFileAtime(string $code): string
    {
        return preg_replace(
            '/\bfileatime\b/',
            'fileatime',
            $code
        ) ?? $code;
    }

    private function compileFileOwner(string $code): string
    {
        return preg_replace(
            '/\bfileowner\b/',
            'fileowner',
            $code
        ) ?? $code;
    }

    private function compileFileGroup(string $code): string
    {
        return preg_replace(
            '/\bfilegroup\b/',
            'filegroup',
            $code
        ) ?? $code;
    }

    private function compileFilePerms(string $code): string
    {
        return preg_replace(
            '/\bfileperms\b/',
            'fileperms',
            $code
        ) ?? $code;
    }

    private function compileFileInode(string $code): string
    {
        return preg_replace(
            '/\bfileinode\b/',
            'fileinode',
            $code
        ) ?? $code;
    }

    private function compileFileType(string $code): string
    {
        return preg_replace(
            '/\bfiletype\b/',
            'filetype',
            $code
        ) ?? $code;
    }

    private function compileCopy(string $code): string
    {
        return preg_replace(
            '/\bcopy\b/',
            'copy',
            $code
        ) ?? $code;
    }

    private function compileMove(string $code): string
    {
        return preg_replace(
            '/\bmove\b/',
            'rename',
            $code
        ) ?? $code;
    }

    private function compileRename(string $code): string
    {
        return preg_replace(
            '/\brename\b/',
            'rename',
            $code
        ) ?? $code;
    }

    private function compileDelete(string $code): string
    {
        return preg_replace(
            '/\bdelete\b/',
            'unlink',
            $code
        ) ?? $code;
    }

    private function compileUnlink(string $code): string
    {
        return preg_replace(
            '/\bunlink\b/',
            'unlink',
            $code
        ) ?? $code;
    }

    private function compileMkdir(string $code): string
    {
        return preg_replace(
            '/\bmkdir\b/',
            'mkdir',
            $code
        ) ?? $code;
    }

    private function compileRmdir(string $code): string
    {
        return preg_replace(
            '/\brmdir\b/',
            'rmdir',
            $code
        ) ?? $code;
    }

    private function compileChmod(string $code): string
    {
        return preg_replace(
            '/\bchmod\b/',
            'chmod',
            $code
        ) ?? $code;
    }

    private function compileChown(string $code): string
    {
        return preg_replace(
            '/\bchown\b/',
            'chown',
            $code
        ) ?? $code;
    }

    private function compileChgrp(string $code): string
    {
        return preg_replace(
            '/\bchgrp\b/',
            'chgrp',
            $code
        ) ?? $code;
    }

    private function compileSymlink(string $code): string
    {
        return preg_replace(
            '/\bsymlink\b/',
            'symlink',
            $code
        ) ?? $code;
    }

    private function compileReadlink(string $code): string
    {
        return preg_replace(
            '/\breadlink\b/',
            'readlink',
            $code
        ) ?? $code;
    }

    private function compileLinkinfo(string $code): string
    {
        return preg_replace(
            '/\blinkinfo\b/',
            'linkinfo',
            $code
        ) ?? $code;
    }

    private function compileLink(string $code): string
    {
        return preg_replace(
            '/\blink\b/',
            'link',
            $code
        ) ?? $code;
    }

    private function compileTouch(string $code): string
    {
        return preg_replace(
            '/\btouch\b/',
            'touch',
            $code
        ) ?? $code;
    }

    private function compileClearstatcache(string $code): string
    {
        return preg_replace(
            '/\bclearstatcache\b/',
            'clearstatcache',
            $code
        ) ?? $code;
    }

    private function compileDiskFreeSpace(string $code): string
    {
        return preg_replace(
            '/\bdisk_free_space\b/',
            'disk_free_space',
            $code
        ) ?? $code;
    }

    private function compileDiskTotalSpace(string $code): string
    {
        return preg_replace(
            '/\bdisk_total_space\b/',
            'disk_total_space',
            $code
        ) ?? $code;
    }

    private function compileGlob(string $code): string
    {
        return preg_replace(
            '/\bglob\b/',
            'glob',
            $code
        ) ?? $code;
    }

    private function compileTempnam(string $code): string
    {
        return preg_replace(
            '/\btempnam\b/',
            'tempnam',
            $code
        ) ?? $code;
    }

    private function compileTmpfile(string $code): string
    {
        return preg_replace(
            '/\btmpfile\b/',
            'tmpfile',
            $code
        ) ?? $code;
    }

    private function compileSysGetTempDir(string $code): string
    {
        return preg_replace(
            '/\bsys_get_temp_dir\b/',
            'sys_get_temp_dir',
            $code
        ) ?? $code;
    }

    private function compileStringFunctions(string $code): string
    {
        return preg_replace(
            '/\bstring\b/',
            'string',
            $code
        ) ?? $code;
    }

    private function compileStrlen(string $code): string
    {
        return preg_replace(
            '/\bstrlen\b/',
            'strlen',
            $code
        ) ?? $code;
    }

    private function compileStrpos(string $code): string
    {
        return preg_replace(
            '/\bstrpos\b/',
            'strpos',
            $code
        ) ?? $code;
    }

    private function compileStripos(string $code): string
    {
        return preg_replace(
            '/\bstripos\b/',
            'stripos',
            $code
        ) ?? $code;
    }

    private function compileStrrpos(string $code): string
    {
        return preg_replace(
            '/\bstrrpos\b/',
            'strrpos',
            $code
        ) ?? $code;
    }

    private function compileStrripos(string $code): string
    {
        return preg_replace(
            '/\bstrripos\b/',
            'strripos',
            $code
        ) ?? $code;
    }

    private function compileSubstr(string $code): string
    {
        return preg_replace(
            '/\bsubstr\b/',
            'substr',
            $code
        ) ?? $code;
    }

    private function compileStrReplace(string $code): string
    {
        return preg_replace(
            '/\bstr_replace\b/',
            'str_replace',
            $code
        ) ?? $code;
    }

    private function compileStrIreplace(string $code): string
    {
        return preg_replace(
            '/\bstr_ireplace\b/',
            'str_ireplace',
            $code
        ) ?? $code;
    }

    private function compileStrtr(string $code): string
    {
        return preg_replace(
            '/\bstrtr\b/',
            'strtr',
            $code
        ) ?? $code;
    }

    private function compileStrShuffle(string $code): string
    {
        return preg_replace(
            '/\bstr_shuffle\b/',
            'str_shuffle',
            $code
        ) ?? $code;
    }

    private function compileStrrev(string $code): string
    {
        return preg_replace(
            '/\bstrrev\b/',
            'strrev',
            $code
        ) ?? $code;
    }

    private function compileStrToLower(string $code): string
    {
        return preg_replace(
            '/\bstrtolower\b/',
            'strtolower',
            $code
        ) ?? $code;
    }

    private function compileStrToUpper(string $code): string
    {
        return preg_replace(
            '/\bstrtoupper\b/',
            'strtoupper',
            $code
        ) ?? $code;
    }

    private function compileUcfirst(string $code): string
    {
        return preg_replace(
            '/\bucfirst\b/',
            'ucfirst',
            $code
        ) ?? $code;
    }

    private function compileUcwords(string $code): string
    {
        return preg_replace(
            '/\bucwords\b/',
            'ucwords',
            $code
        ) ?? $code;
    }

    private function compileLcfirst(string $code): string
    {
        return preg_replace(
            '/\blcfirst\b/',
            'lcfirst',
            $code
        ) ?? $code;
    }

    private function compileTrim(string $code): string
    {
        return preg_replace(
            '/\btrim\b/',
            'trim',
            $code
        ) ?? $code;
    }

    private function compileLtrim(string $code): string
    {
        return preg_replace(
            '/\bltrim\b/',
            'ltrim',
            $code
        ) ?? $code;
    }

    private function compileRtrim(string $code): string
    {
        return preg_replace(
            '/\brtrim\b/',
            'rtrim',
            $code
        ) ?? $code;
    }

    private function compileChop(string $code): string
    {
        return preg_replace(
            '/\bchop\b/',
            'chop',
            $code
        ) ?? $code;
    }

    private function compileChunkSplit(string $code): string
    {
        return preg_replace(
            '/\bchunk_split\b/',
            'chunk_split',
            $code
        ) ?? $code;
    }

    private function compileExplode(string $code): string
    {
        return preg_replace(
            '/\bexplode\b/',
            'explode',
            $code
        ) ?? $code;
    }

    private function compileImplode(string $code): string
    {
        return preg_replace(
            '/\bimplode\b/',
            'implode',
            $code
        ) ?? $code;
    }

    private function compileJoin(string $code): string
    {
        return preg_replace(
            '/\bjoin\b/',
            'join',
            $code
        ) ?? $code;
    }

    private function compileStrSplit(string $code): string
    {
        return preg_replace(
            '/\bstr_split\b/',
            'str_split',
            $code
        ) ?? $code;
    }

    private function compileStrRepeat(string $code): string
    {
        return preg_replace(
            '/\bstr_repeat\b/',
            'str_repeat',
            $code
        ) ?? $code;
    }

    private function compileWordwrap(string $code): string
    {
        return preg_replace(
            '/\bwordwrap\b/',
            'wordwrap',
            $code
        ) ?? $code;
    }

    private function compileNl2br(string $code): string
    {
        return preg_replace(
            '/\bnl2br\b/',
            'nl2br',
            $code
        ) ?? $code;
    }

    private function compileStripTags(string $code): string
    {
        return preg_replace(
            '/\bstrip_tags\b/',
            'strip_tags',
            $code
        ) ?? $code;
    }

    private function compileHtmlentities(string $code): string
    {
        return preg_replace(
            '/\bhtmlentities\b/',
            'htmlentities',
            $code
        ) ?? $code;
    }

    private function compileHtmlEntityDecode(string $code): string
    {
        return preg_replace(
            '/\bhtml_entity_decode\b/',
            'html_entity_decode',
            $code
        ) ?? $code;
    }

    private function compileHtmlspecialchars(string $code): string
    {
        return preg_replace(
            '/\bhtmlspecialchars\b/',
            'htmlspecialchars',
            $code
        ) ?? $code;
    }

    private function compileHtmlspecialcharsDecode(string $code): string
    {
        return preg_replace(
            '/\bhtmlspecialchars_decode\b/',
            'htmlspecialchars_decode',
            $code
        ) ?? $code;
    }

    private function compileAddslashes(string $code): string
    {
        return preg_replace(
            '/\baddslashes\b/',
            'addslashes',
            $code
        ) ?? $code;
    }

    private function compileStripslashes(string $code): string
    {
        return preg_replace(
            '/\bstripslashes\b/',
            'stripslashes',
            $code
        ) ?? $code;
    }

    private function compileQuotemeta(string $code): string
    {
        return preg_replace(
            '/\bquotemeta\b/',
            'quotemeta',
            $code
        ) ?? $code;
    }

    private function compileStripcslashes(string $code): string
    {
        return preg_replace(
            '/\bstripcslashes\b/',
            'stripcslashes',
            $code
        ) ?? $code;
    }

    private function compileAddcslashes(string $code): string
    {
        return preg_replace(
            '/\baddcslashes\b/',
            'addcslashes',
            $code
        ) ?? $code;
    }

    private function compileParseStr(string $code): string
    {
        return preg_replace(
            '/\bparse_str\b/',
            'parse_str',
            $code
        ) ?? $code;
    }

    private function compileStrPad(string $code): string
    {
        return preg_replace(
            '/\bstr_pad\b/',
            'str_pad',
            $code
        ) ?? $code;
    }

    private function compileStrColl(string $code): string
    {
        return preg_replace(
            '/\bstrcoll\b/',
            'strcoll',
            $code
        ) ?? $code;
    }

    private function compileSubstrCount(string $code): string
    {
        return preg_replace(
            '/\bsubstr_count\b/',
            'substr_count',
            $code
        ) ?? $code;
    }

    private function compileStrCasecmp(string $code): string
    {
        return preg_replace(
            '/\bstrcasecmp\b/',
            'strcasecmp',
            $code
        ) ?? $code;
    }

    private function compileStrnatcmp(string $code): string
    {
        return preg_replace(
            '/\bstrnatcmp\b/',
            'strnatcmp',
            $code
        ) ?? $code;
    }

    private function compileStrnatcasecmp(string $code): string
    {
        return preg_replace(
            '/\bstrnatcasecmp\b/',
            'strnatcasecmp',
            $code
        ) ?? $code;
    }

    private function compileStrncmp(string $code): string
    {
        return preg_replace(
            '/\bstrncmp\b/',
            'strncmp',
            $code
        ) ?? $code;
    }

    private function compileStrncasecmp(string $code): string
    {
        return preg_replace(
            '/\bstrncasecmp\b/',
            'strncasecmp',
            $code
        ) ?? $code;
    }

    private function compileStrcmp(string $code): string
    {
        return preg_replace(
            '/\bstrcmp\b/',
            'strcmp',
            $code
        ) ?? $code;
    }

    private function compileStrstr(string $code): string
    {
        return preg_replace(
            '/\bstrstr\b/',
            'strstr',
            $code
        ) ?? $code;
    }

    private function compileStristr(string $code): string
    {
        return preg_replace(
            '/\bstristr\b/',
            'stristr',
            $code
        ) ?? $code;
    }

    private function compileStrrchr(string $code): string
    {
        return preg_replace(
            '/\bstrrchr\b/',
            'strrchr',
            $code
        ) ?? $code;
    }

    private function compileSubstrReplace(string $code): string
    {
        return preg_replace(
            '/\bsubstr_replace\b/',
            'substr_replace',
            $code
        ) ?? $code;
    }

    private function compileStrIreplaceArray(string $code): string
    {
        return preg_replace(
            '/\bstr_ireplace\b/',
            'str_ireplace',
            $code
        ) ?? $code;
    }

    private function compileStrReplaceArray(string $code): string
    {
        return preg_replace(
            '/\bstr_replace\b/',
            'str_replace',
            $code
        ) ?? $code;
    }

    private function compileStrposArray(string $code): string
    {
        return preg_replace(
            '/\bstrpos\b/',
            'strpos',
            $code
        ) ?? $code;
    }

    private function compileStriposArray(string $code): string
    {
        return preg_replace(
            '/\bstripos\b/',
            'stripos',
            $code
        ) ?? $code;
    }

    private function compileStrrposArray(string $code): string
    {
        return preg_replace(
            '/\bstrrpos\b/',
            'strrpos',
            $code
        ) ?? $code;
    }

    private function compileStrriposArray(string $code): string
    {
        return preg_replace(
            '/\bstrripos\b/',
            'strripos',
            $code
        ) ?? $code;
    }

    private function compileSubstrCompare(string $code): string
    {
        return preg_replace(
            '/\bsubstr_compare\b/',
            'substr_compare',
            $code
        ) ?? $code;
    }

    private function compileStrptime(string $code): string
    {
        return preg_replace(
            '/\bstrptime\b/',
            'strptime',
            $code
        ) ?? $code;
    }

    private function compileStrftime(string $code): string
    {
        return preg_replace(
            '/\bstrftime\b/',
            'strftime',
            $code
        ) ?? $code;
    }

    private function compileGmstrftime(string $code): string
    {
        return preg_replace(
            '/\bgmstrftime\b/',
            'gmstrftime',
            $code
        ) ?? $code;
    }

    private function compileDateFunctions(string $code): string
    {
        return preg_replace(
            '/\bdate\b/',
            'date',
            $code
        ) ?? $code;
    }

    private function compileDate(string $code): string
    {
        return preg_replace(
            '/\bdate\b/',
            'date',
            $code
        ) ?? $code;
    }

    private function compileGmdate(string $code): string
    {
        return preg_replace(
            '/\bgmdate\b/',
            'gmdate',
            $code
        ) ?? $code;
    }

    private function compileTime(string $code): string
    {
        return preg_replace(
            '/\btime\b/',
            'time',
            $code
        ) ?? $code;
    }

    private function compileMicrotime(string $code): string
    {
        return preg_replace(
            '/\bmicrotime\b/',
            'microtime',
            $code
        ) ?? $code;
    }

    private function compileMktime(string $code): string
    {
        return preg_replace(
            '/\bmktime\b/',
            'mktime',
            $code
        ) ?? $code;
    }

    private function compileGmmktime(string $code): string
    {
        return preg_replace(
            '/\bgmmktime\b/',
            'gmmktime',
            $code
        ) ?? $code;
    }

    private function compileStrToTime(string $code): string
    {
        return preg_replace(
            '/\bstrtotime\b/',
            'strtotime',
            $code
        ) ?? $code;
    }

    private function compileStrToTimeSafe(string $code): string
    {
        return preg_replace(
            '/\bstrtotime\b/',
            'strtotime',
            $code
        ) ?? $code;
    }

    private function compileDateDefaultTimezoneSet(string $code): string
    {
        return preg_replace(
            '/\bdate_default_timezone_set\b/',
            'date_default_timezone_set',
            $code
        ) ?? $code;
    }

    private function compileDateDefaultTimezoneGet(string $code): string
    {
        return preg_replace(
            '/\bdate_default_timezone_get\b/',
            'date_default_timezone_get',
            $code
        ) ?? $code;
    }

    private function compileDateSunrise(string $code): string
    {
        return preg_replace(
            '/\bdate_sunrise\b/',
            'date_sunrise',
            $code
        ) ?? $code;
    }

    private function compileDateSunset(string $code): string
    {
        return preg_replace(
            '/\bdate_sunset\b/',
            'date_sunset',
            $code
        ) ?? $code;
    }

    private function compileDateParse(string $code): string
    {
        return preg_replace(
            '/\bdate_parse\b/',
            'date_parse',
            $code
        ) ?? $code;
    }

    private function compileDateParseFromFormat(string $code): string
    {
        return preg_replace(
            '/\bdate_parse_from_format\b/',
            'date_parse_from_format',
            $code
        ) ?? $code;
    }

    private function compileDateCreate(string $code): string
    {
        return preg_replace(
            '/\bdate_create\b/',
            'date_create',
            $code
        ) ?? $code;
    }

    private function compileDateCreateFromFormat(string $code): string
    {
        return preg_replace(
            '/\bdate_create_from_format\b/',
            'date_create_from_format',
            $code
        ) ?? $code;
    }

    private function compileDateGetLastErrors(string $code): string
    {
        return preg_replace(
            '/\bdate_get_last_errors\b/',
            'date_get_last_errors',
            $code
        ) ?? $code;
    }

    private function compileDateTimeClass(string $code): string
    {
        return preg_replace(
            '/\bDateTime\b/',
            'DateTime',
            $code
        ) ?? $code;
    }

    private function compileDateTimeInterface(string $code): string
    {
        return preg_replace(
            '/\bDateTimeInterface\b/',
            'DateTimeInterface',
            $code
        ) ?? $code;
    }

    private function compileDateTimeImmutable(string $code): string
    {
        return preg_replace(
            '/\bDateTimeImmutable\b/',
            'DateTimeImmutable',
            $code
        ) ?? $code;
    }

    private function compileDateInterval(string $code): string
    {
        return preg_replace(
            '/\bDateInterval\b/',
            'DateInterval',
            $code
        ) ?? $code;
    }

    private function compileDatePeriod(string $code): string
    {
        return preg_replace(
            '/\bDatePeriod\b/',
            'DatePeriod',
            $code
        ) ?? $code;
    }

    private function compileDateTimeZone(string $code): string
    {
        return preg_replace(
            '/\bDateTimeZone\b/',
            'DateTimeZone',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneOpen(string $code): string
    {
        return preg_replace(
            '/\btimezone_open\b/',
            'timezone_open',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneName(string $code): string
    {
        return preg_replace(
            '/\btimezone_name_get\b/',
            'timezone_name_get',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneIdentifiersList(string $code): string
    {
        return preg_replace(
            '/\btimezone_identifiers_list\b/',
            'timezone_identifiers_list',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneLocationGet(string $code): string
    {
        return preg_replace(
            '/\btimezone_location_get\b/',
            'timezone_location_get',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneTransitions(string $code): string
    {
        return preg_replace(
            '/\btimezone_transitions_get\b/',
            'timezone_transitions_get',
            $code
        ) ?? $code;
    }

    private function compileTimeZoneOffset(string $code): string
    {
        return preg_replace(
            '/\btimezone_offset_get\b/',
            'timezone_offset_get',
            $code
        ) ?? $code;
    }

    private function compileDateTimeDiff(string $code): string
    {
        return preg_replace(
            '/\bdate_diff\b/',
            'date_diff',
            $code
        ) ?? $code;
    }

    private function compileDateTimeAdd(string $code): string
    {
        return preg_replace(
            '/\bdate_add\b/',
            'date_add',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSub(string $code): string
    {
        return preg_replace(
            '/\bdate_sub\b/',
            'date_sub',
            $code
        ) ?? $code;
    }

    private function compileDateTimeModify(string $code): string
    {
        return preg_replace(
            '/\bdate_modify\b/',
            'date_modify',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSetDate(string $code): string
    {
        return preg_replace(
            '/\bdate_set_date\b/',
            'date_set_date',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSetISODate(string $code): string
    {
        return preg_replace(
            '/\bdate_set_isodate\b/',
            'date_set_isodate',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSetTime(string $code): string
    {
        return preg_replace(
            '/\bdate_set_time\b/',
            'date_set_time',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSetTimestamp(string $code): string
    {
        return preg_replace(
            '/\bdate_set_timestamp\b/',
            'date_set_timestamp',
            $code
        ) ?? $code;
    }

    private function compileDateTimeGetTimestamp(string $code): string
    {
        return preg_replace(
            '/\bdate_get_timestamp\b/',
            'date_get_timestamp',
            $code
        ) ?? $code;
    }

    private function compileDateTimeFormat(string $code): string
    {
        return preg_replace(
            '/\bdate_format\b/',
            'date_format',
            $code
        ) ?? $code;
    }

    private function compileDateTimeGetOffset(string $code): string
    {
        return preg_replace(
            '/\bdate_get_offset\b/',
            'date_get_offset',
            $code
        ) ?? $code;
    }

    private function compileDateTimeGetTimeZone(string $code): string
    {
        return preg_replace(
            '/\bdate_get_timezone\b/',
            'date_get_timezone',
            $code
        ) ?? $code;
    }

    private function compileDateTimeSetTimeZone(string $code): string
    {
        return preg_replace(
            '/\bdate_set_timezone\b/',
            'date_set_timezone',
            $code
        ) ?? $code;
    }

    private function compileDateTimeCreateFromImmutable(string $code): string
    {
        return preg_replace(
            '/\bDateTime::createFromImmutable\b/',
            'DateTime::createFromImmutable',
            $code
        ) ?? $code;
    }

    private function compileDateTimeImmutableCreateFromMutable(string $code): string
    {
        return preg_replace(
            '/\bDateTimeImmutable::createFromMutable\b/',
            'DateTimeImmutable::createFromMutable',
            $code
        ) ?? $code;
    }

    private function compileDateIntervalCreateFromDateString(string $code): string
    {
        return preg_replace(
            '/\bDateInterval::createFromDateString\b/',
            'DateInterval::createFromDateString',
            $code
        ) ?? $code;
    }

    private function compileDateIntervalFormat(string $code): string
    {
        return preg_replace(
            '/\bdate_interval_format\b/',
            'date_interval_format',
            $code
        ) ?? $code;
    }

    private function compileDatePeriodGetDateInterval(string $code): string
    {
        return preg_replace(
            '/\bDatePeriod::getDateInterval\b/',
            'DatePeriod::getDateInterval',
            $code
        ) ?? $code;
    }

    private function compileDatePeriodGetEndDate(string $code): string
    {
        return preg_replace(
            '/\bDatePeriod::getEndDate\b/',
            'DatePeriod::getEndDate',
            $code
        ) ?? $code;
    }

    private function compileDatePeriodGetStartDate(string $code): string
    {
        return preg_replace(
            '/\bDatePeriod::getStartDate\b/',
            'DatePeriod::getStartDate',
            $code
        ) ?? $code;
    }

    private function compileDatePeriodGetRecurrences(string $code): string
    {
        return preg_replace(
            '/\bDatePeriod::getRecurrences\b/',
            'DatePeriod::getRecurrences',
            $code
        ) ?? $code;
    }

    private function compileDateTimeGetLastErrors(string $code): string
    {
        return preg_replace(
            '/\bDateTime::getLastErrors\b/',
            'DateTime::getLastErrors',
            $code
        ) ?? $code;
    }

    private function compileDateTimeWarnings(string $code): string
    {
        return preg_replace(
            '/\bDateTime::getWarnings\b/',
            'DateTime::getWarnings',
            $code
        ) ?? $code;
    }

    private function compileDateTimeErrors(string $code): string
    {
        return preg_replace(
            '/\bDateTime::getErrors\b/',
            'DateTime::getErrors',
            $code
        ) ?? $code;
    }

    public function addKeyword(string $xl, string $php): void
    {
        $this->keywords[$xl] = $php;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }

    public function clearCache(): void
    {
        $this->cache = [];
    }
}
