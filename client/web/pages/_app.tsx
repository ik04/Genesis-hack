import "../styles/globals.css";
import "@rainbow-me/rainbowkit/styles.css";
import {
  getDefaultWallets,
  lightTheme,
  RainbowKitProvider,
} from "@rainbow-me/rainbowkit";
import type { AppProps } from "next/app";
import { type Chain } from "viem";
import { publicProvider } from "wagmi/providers/public";
import { configureChains, createConfig, WagmiConfig } from "wagmi";
const beratest = {
  id: 80085,
  network: "Berachain Artio",
  name: "Berachain Artio",
  nativeCurrency: { name: "Bera", symbol: "BERA", decimals: 18 },
  rpcUrls: {
    default: { http: ["https://artio.rpc.berachain.com/"] },
    public: { http: ["https://artio.rpc.berachain.com/"] },
  },
  blockExplorers: {
    default: { name: "Artio Testnet", url: "https://artio.beratrail.io/" },
  },
  testnet: true,
};

import { polygonMumbai, goerli, mainnet, optimism } from "wagmi/chains";
import { GlobalState } from "../context/GlobalState";
import axios from "axios";

axios.defaults.withCredentials = true;

const { chains, publicClient, webSocketPublicClient } = configureChains(
  [
    mainnet,
    beratest,
    optimism,

    polygonMumbai,
    ...(process.env.NEXT_PUBLIC_ENABLE_TESTNETS === "true" ? [goerli] : []),
  ],
  [publicProvider()]
);

const { connectors } = getDefaultWallets({
  appName: "SocialMediaApp",
  projectId: "YOUR_PROJECT_ID",

  chains,
});

const wagmiConfig = createConfig({
  autoConnect: true,
  connectors,
  publicClient,
  webSocketPublicClient,
});

function MyApp({ Component, pageProps }: AppProps) {
  return (
    <WagmiConfig config={wagmiConfig}>
      <RainbowKitProvider
        chains={chains}
        theme={lightTheme({
          accentColor: "#1A040B",
          accentColorForeground: "#E7C4B1",
        })}
      >
        <GlobalState>
          <Component {...pageProps} />
        </GlobalState>
      </RainbowKitProvider>
    </WagmiConfig>
  );
}

export default MyApp;
