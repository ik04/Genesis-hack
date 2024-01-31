import honey from "../assets/honeypot.png"
import Image from "next/image";

interface PostProps {
    isHoney: boolean;
    answers: number;
    votes: number;
    title: string;
    desc: string;
}

export default function Post({ isHoney, answers,votes,title,desc }: PostProps) {
    return (
        <div className="flex p-7 border-b-2 border-[#E7C4B1] gap-8">
            <div className="flex flex-col">
                {isHoney ? (
                    <div className="flex flex-col gap-5 items-center text-center justify-center">
                        <Image src={honey} alt="Honeypot" />
                        <h1 className="text-white font-Mont text-sm w-24"> {votes} Votes </h1>
                    </div>
                ) : (
                    <div className="flex flex-col gap-5 items-center  justify-center">
                        <h1 className="text-[#1A040B] bg-[#E7C4B1] w-24 rounded-lg h-6 text-center"> {answers} Answers</h1>
                        <h2 className="text-white font-Mont text-sm text-center">{votes} Votes</h2>

                    </div>
                )}
            </div>
            <div className="flex flex-col">
                    <h1 className="text-white font-Mont text-4xl font-semibold"> {title} </h1>
                    <h2 className="text-white font-Mont text-xl"> {desc} </h2>
            </div>
        </div>
    );
}
