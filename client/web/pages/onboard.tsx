import axios from "axios";
import React, { useEffect, useState } from "react";
import { useAccount } from "wagmi";

const onboard = () => {
  // todo: improve the design later, give scaffolding to work on
  const [name, setName] = useState<any>();
  const [username, setUsername] = useState<any>();
  // its a hackathon so these sins are allowed
  const { isConnected } = useAccount();

  useEffect(() => {
    if (!isConnected) {
      location.href = "/";
    }
  });
  const onboardUser = async (e: any) => {
    e.preventDefault();
    // ! use toast for handling errors and successes
    if (username && name) {
      const url = `${process.env.NEXT_PUBLIC_DOMAIN}/api/add/profile`;
      const resp = axios.post(url, { name: name, username: username });
      console.log(resp);
    }
  };
  return (
    <div className="h-screen bg-[#1A040B] justify-center items-center flex">
      <div className="bg-[#E7C4B1] flex flex-col">
        <label htmlFor="name">Name:</label>
        <input
          name="name"
          onChange={(e) => setName(e.target.value)}
          type="text"
        />
        <label htmlFor="name">Username:</label>
        <input
          name="username"
          onChange={(e) => setUsername(e.target.value)}
          type="text"
        />{" "}
        <div className="text-black text-center" onClick={onboardUser}>
          Submit
        </div>
      </div>
    </div>
  );
};

export default onboard;
