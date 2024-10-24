const { connect, keyStores, WalletConnection } = nearApi;

async function initNear() {
    const nearConfig = {
        networkId: 'mainnet',
        keyStore: new keyStores.BrowserLocalStorageKeyStore(),
        nodeUrl: 'https://rpc.mainnet.near.org',
        walletUrl: 'https://wallet.near.org',
    };

    const near = await connect(nearConfig);
    const wallet = new WalletConnection(near);

    // Elementos del DOM
    const loginButton = document.getElementById('loginButton');
    const userInfo = document.getElementById('userInfo');
    const accountId = document.getElementById('accountId');

    // Iniciar sesión
    loginButton.onclick = async () => {
        if (!wallet.isSignedIn()) {
            await wallet.requestSignIn({ contractId: null });
        } else {
            userInfo.style.display = 'block';
            accountId.textContent = wallet.getAccountId();
        }
    };

    // Mostrar información si ya está autenticado
    if (wallet.isSignedIn()) {
        userInfo.style.display = 'block';
        accountId.textContent = wallet.getAccountId();
    }
}

window.onload = initNear;
