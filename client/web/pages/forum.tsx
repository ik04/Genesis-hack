import { useState } from "react";
import Image from "next/image";
import { ConnectButton } from '@rainbow-me/rainbowkit';

const forum = ()=>{
    const [inputText,setInputText] = useState("")

   const handleSearch = () => {
    console.log(inputText);
  };
  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setInputText(event.target.value);
};
    return(
        <main className=' bg-[#1A040B] min-h-screen'>
        <div className='nav p-5 flex gap-1 xl:gap-5 items-center border-b-2 border-[#E7C4B1] '>
          <div className=''>
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
  <circle cx="25" cy="25" r="25" fill="#7A7A7A"/>
</svg>
          </div>
        <h1 className='text-[#E7C4B1] text-lg xl:text-3xl font-Mont font-bold '> Bear Hug </h1>
        
        <input value={inputText} onChange={handleInputChange} className='2xl:w-[50rem] w-16 xl:w-96 xl:h-12 rounded-2xl bg-[#1A040B] border-2 border-[#E7C4B1] p-2 ' placeholder='Search...'  />
        <button onClick={handleSearch} className='bg-transparent border-2 border-[#E7C4B1] text-[#E7C4B1] p-2 rounded-2xl hover:scale-110 transition-all'> Search </button>
        <ConnectButton />
        </div>

      <div className='flex items-center justify-center'>
       
        
      </div>
      </main>
    )
}

export default forum;