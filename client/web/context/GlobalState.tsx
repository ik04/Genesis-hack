import { ReactNode, useEffect } from "react";

import { GlobalContext } from "./GlobalContext";
import axios from "axios";
import { useAccount } from "wagmi";

interface GlobalStateProps {
  children: ReactNode;
}

export const GlobalState = ({ children }: GlobalStateProps) => {
  const { isConnected, address } = useAccount();

  const callUserData = async () => {
    try {
      if (isConnected) {
        const resp = await axios.get(
          `${process.env.NEXT_PUBLIC_DOMAIN}/api/user-data`
        );
        axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${resp.data.access_token}`;
        console.log(resp);
      }
    } catch (error) {
      console.log(error);
    }
  };
  useEffect(() => {
    callUserData();
  }, []);

  return <GlobalContext.Provider value={""}>{children}</GlobalContext.Provider>;
};
