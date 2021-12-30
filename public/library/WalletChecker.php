<?php

namespace App\Library;

use DG\Twitter\Exception;
use GuzzleHttp\Exception\GuzzleException;
use LNPayClient\LNPayClient;
use LNPayClient\Wallet;

class WalletChecker
{
    private Wallet $wallet;
    private LNPayClient $lnPay;
    private LNPayClient $lnPayAdmin;

    public function __construct()
    {
        $this->wallet = new Wallet();
        $this->lnPay = new LNPayClient(
            $_ENV['LNPAY_SECRET_API_KEY'],
            $_ENV['LNPAY_WALLET_KEY'],
        );
    }

    /**
     * Return current balance
     *
     */
    public function getBalance(): int
    {
        $balance = 0;
        try {
            $walletBalance = $this->wallet->getInfo();
            $walletBalanceDecode = json_decode($walletBalance);
            if ($walletBalanceDecode !== null) {
                /**
                 * Inform current balance
                 */
                $balance = (int) $walletBalanceDecode->balance;
            } else {
                throw new \Exception('LNPay API return null');
            }
        } catch (Exception | GuzzleException $e) {
            throw new \Exception('Failed reaching LN wallet API');
        }

        return $balance;
    }

    /**
     * Formatted balance
     */
    public function getFormattedBalance(): string
    {
        $amount = $this->getBalance();
        return $this->formatSats($amount);
    }

    /**
     * Format balance
     */
    public function formatSats(int $amount): string
    {
        return number_format($amount) . ($amount <= 1 ? ' sat' : ' sats');
    }
}
