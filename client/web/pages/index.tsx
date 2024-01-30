import { ConnectButton } from '@rainbow-me/rainbowkit';
import type { NextPage } from 'next';
import { useState } from 'react';
import Head from 'next/head';
import Image from 'next/image';
import { useRouter } from 'next/router';
import trees from "../assets/Group.png"
const Home: NextPage = () => {

   const [inputText,setInputText] = useState("")
   const router = useRouter();
   const handleSearch = () => {
    console.log(inputText);
    router.push('/forum');
  };
  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setInputText(event.target.value);
};
  return (
    <div>
      <Head>
        <title>Bear Hug</title>
        <meta
          content="Bear Hug forums for blockchain developers"
          name="description"
        />
        <link href="/favicon.ico" rel="icon" />
      </Head>

      <main className=' bg-[#E7C4B1] min-h-screen'>
        <div className='nav p-5 flex gap-1 xl:gap-5 items-center '>
          <div className=''>
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
  <circle cx="25" cy="25" r="25" fill="#7A7A7A"/>
</svg>
          </div>
        <a href='/' className='text-[#1A040B] text-lg xl:text-3xl font-Mont font-bold '> Bear Hug </a>
        <div className='buttons  gap-7 ml-[30px] hidden lg:flex'>
        <a href='/' className='text-[#1A040B] text-2xl font-normal font-Mont'> Rewards </a>
        <a  href='#about' className='text-[#1A040B] text-2xl font-normal font-Mont'> About </a>
       
        </div>
        <input value={inputText} onChange={handleInputChange} className='2xl:w-[50rem] w-16 xl:w-96 xl:h-12 rounded-2xl bg-[#E7C4B1] border-2 border-[#1A040B] p-2 xl:ml-4' placeholder='Search...'  />
        <button onClick={handleSearch} className='bg-transparent border-2 border-white p-2 rounded-2xl hover:scale-110 transition-all'> Search </button>
        <ConnectButton />
        </div>

      <div className='flex items-center justify-center'>
        <h1 className='font-Mont text-[#1A040B] text-5xl xl:text-6xl text-center p-10'> Where <b>blockchain</b> developers get a <b>'pawsitive'</b> lift </h1>
        <Image src={trees} className='bottom-0 absolute' />
      </div>
      </main>
      <div className='bg-[#1A040B] min-h-screen '>

      </div>

      
    </div>
  );
};

export default Home;
