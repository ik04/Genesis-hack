import { ReactNode } from "react";

import { GlobalContext } from "./GlobalContext";

interface GlobalStateProps {
  children: ReactNode;
}

export const GlobalState = ({ children }: GlobalStateProps) => {
  return <GlobalContext.Provider value={""}>{children}</GlobalContext.Provider>;
};
