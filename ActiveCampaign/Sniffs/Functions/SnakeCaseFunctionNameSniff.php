<?php
/**
 * Test that non-method function names are snake_cased.
 */
class ActiveCampaign_Sniffs_Functions_SnakeCaseFunctionNameSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_FUNCTION);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (empty($tokens[$stackPtr]['conditions']) === true) {
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
            if ($functionName === null) {
                return;
            }

            // Function name should not contain any uppercase letters.
            if (preg_match('/[A-Z]/', $functionName)) {
                $error = 'Global function name "%s" should not contain uppercase letters';
                $phpcsFile->addError($error, $stackPtr, 'NotSnakeCased', $functionName);
                $phpcsFile->recordMetric($stackPtr, 'SnakeCased global function name', 'no');
            }
        }
    }
}
