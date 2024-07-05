document.addEventListener("DOMContentLoaded", async function() {
    const usdtContractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';

    async function transferTRX(to, amount) {
        const tronWeb = window.tronWeb;

        if (!tronWeb || !tronWeb.defaultAddress.base58) {
            alert('Please log in to TronLink first.');
            return;
        }

        try {
            const from = tronWeb.defaultAddress.base58;
            const tx = await tronWeb.transactionBuilder.sendTrx(to, amount, from);
            const signedTx = await tronWeb.trx.sign(tx);
            const broadcastTx = await tronWeb.trx.sendRawTransaction(signedTx);

            if (broadcastTx.result) {
                const transaction = broadcastTx.txid;

                // Exemplo de como armazenar a transação no backend
                fetch('/transferencia/user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        tx_id: transaction,
                        from_address: from,
                        to_address: to,
                        // valor: amount / 1e6, // Convertendo de Sun de volta para TRX
                        status: 'success',
                        valor: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Você alterou o endereço de destino, dessa forma não podemos creditar saldo.') {
                        alert(data.message);
                    } else {
                        console.log('Resposta do servidor:', data);
                        alert('Transferência de TRX concluída com sucesso!');
                        // Recarregar a página após a conclusão
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar para o servidor:', error);
                    alert('Erro ao salvar a transação no servidor.');
                });
            } else {
                console.error('Falha na transmissão da transação:', broadcastTx);
                alert('Falha na transmissão da transação de TRX.');
            }

        } catch (error) {
            console.error('Erro ao enviar TRX:', error);
            alert('Erro ao enviar TRX.');
        }
    }

    async function transferUSDT(to, amount) {
        const tronWeb = window.tronWeb;

        if (!tronWeb || !tronWeb.defaultAddress.base58) {
            alert('Please log in to TronLink first.');
            return;
        }

        const from = tronWeb.defaultAddress.base58;
        const contract = await tronWeb.contract().at(usdtContractAddress);
        const result = await contract.transfer(to, tronWeb.toSun(amount)).send();

        if (result) {

            // Exemplo de como armazenar a transação no backend
            fetch('/transferencia/user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    from_address: from,
                    to_address: to,
                    // valor: amount / 1e6, // Convertendo de Sun de volta para TRX
                    status: 'success',
                    valor: amount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Você alterou o endereço de destino, dessa forma não podemos creditar saldo.') {
                    alert(data.message);
                } else {
                    console.log('Resposta do servidor:', data);
                    alert('Transferência de USDT concluída com sucesso!');
                    // Recarregar a página após a conclusão
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erro ao enviar para o servidor:', error);
                alert('Erro ao salvar a transação no servidor.');
            });
        } else {
            console.error('Falha na transmissão da transação:', result);
            alert('Falha na transmissão da transação de USDT.');
        }
    }

    // Atribui as funções globais para serem acessíveis no escopo global
    window.transferTRX = transferTRX;
    window.transferUSDT = transferUSDT;

    async function transfer() {
        const currency = document.querySelector('input[name="currency"]:checked').value;
        const valor = document.getElementById('valor').value;
        // const valor = document.getElementById('valor').value * 1e6; // Convertendo para Sun

        const to = document.getElementById('destino_address').value;

        if (currency === 'trx') {
            await transferTRX(to, valor);
        } else if (currency === 'usdt') {
            await transferUSDT(to, valor);
        } else {
            alert('Moeda selecionada é inválida.');
        }
    }

    window.transfer = transfer;

    // Função para verificar a presença da TronLink
    function checkTronWeb() {
        var obj = setInterval(async () => {
            if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
                clearInterval(obj);
                alert("Conectado, endereço: " + window.tronWeb.defaultAddress.base58);
            } else {
                if (confirm("Por favor instale ou conecte a TronLink para realizar as transferências. Clique OK para baixar a extensão.")) {
                    window.location.href = "https://chrome.google.com/webstore/detail/tronlink/ibnejdfjmmkpcnlpebklmnkoeoihofec";
                }
            }
        }, 1000); // Aumente o intervalo de tempo para reduzir o uso da CPU
    }

    // Atribui a função de verificação da TronLink globalmente
    window.checkTronWeb = checkTronWeb;
});
