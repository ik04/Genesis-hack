import { ReactNode, useEffect, useState } from "react";

import { GlobalContext } from "./GlobalContext";
import axios from "axios";
import { useAccount } from "wagmi";

interface GlobalStateProps {
  children: ReactNode;
}

export const GlobalState = ({ children }: GlobalStateProps) => {
  const { isConnected, address } = useAccount();
  const [name, setName] = useState();
  const [username, setUsername] = useState();

  const callUserData = async () => {
    try {
      if (isConnected) {
        const resp: any = await axios.get(
          `${process.env.NEXT_PUBLIC_DOMAIN}/api/user-data`
        );
        axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${resp.data.access_token}`;
        console.log(resp);
        if (resp.data.name) {
          setName(resp.data.name);
        }
        if (resp.data.username) {
          setUsername(resp.data.username);
        }
      }
    } catch (error) {
      console.log(error);
    }
  };
  useEffect(() => {
    callUserData();
  }, []);

  return (
    <GlobalContext.Provider value={{ name, username }}>
      {children}
    </GlobalContext.Provider>
  );
};
