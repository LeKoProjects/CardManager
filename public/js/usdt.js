document.addEventListener("DOMContentLoaded", async function() {
    const usdtContractAddress = 'TXLAQ63Xg1NAzckPwKHvzw7CSEmLMEqcdj';

    async function transferUSDT(to, amount) {
        const tronWeb = window.tronWeb;

        if (!tronWeb || !tronWeb.defaultAddress.base58) {
            alert('Please log in to TronLink first.');
            return;
        }

        const from = tronWeb.defaultAddress.base58;

        try {
            const contract = await tronWeb.contract().at(usdtContractAddress);
            const result = await contract.transfer(to, tronWeb.toSun(amount)).send();
            return result;
        } catch (error) {
            throw new Error('Transfer failed: ' + error.message);
        }
    }

    // Atribui a função de transferência globalmente para ser acessível no escopo global
    window.transferUSDT = transferUSDT;
});
