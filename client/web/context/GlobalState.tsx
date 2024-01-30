import axios from "axios";
import { ReactNode, useEffect } from "react";
import { useAccount } from "wagmi";
import { GlobalContext } from "./GlobalContext";

export const GlobalState = (children: any) => {
  const { isConnected, address } = useAccount();
  useEffect(() => {
    const handleConnect = async () => {
      if (isConnected) {
        try {
          const resp = await axios.post(
            `${process.env.NEXT_PUBLIC_DOMAIN}/api/authenticate`,
            { wallet_address: address }
          );
          console.log("Authentication response:", resp.data);
        } catch (error) {
          console.error("Error authenticating:", error);
        }
      } else {
        console.log("No account found");
      }
    };
    handleConnect();
  }, []);

  return <GlobalContext.Provider value={""}>{children}</GlobalContext.Provider>;
};
