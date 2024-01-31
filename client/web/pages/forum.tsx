import axios from "axios";
import { Dashboard } from "../components/dashboard";

const forum = () => {
  return (
    <Dashboard>
      {
        <div className="h-44 px-6 py-9 border-b-2 border-[#E7C4B1] w-screen flex flex-col">
          <h1 className="text-white text-2xl font-Mont"> Results for: </h1>
          <h2 className="text-white text-4xl font-Mont font-bold">
            {" "}
            "inputText from useState goes here"{" "}
          </h2>
        </div>
      }
    </Dashboard>
  );
};

export default forum;
export async function getServerSideProps(context: any) {
  const url = "http://localhost:8000/api/user-data";
  const cookie = context.req.cookies.at;
  if (!cookie) {
    return { props: {} };
  }
  const resp1 = await axios.get(url, { headers: { Cookie: `at=${cookie}` } });
  console.log(resp1);

  axios.defaults.headers.common[
    "Authorization"
  ] = `Bearer ${resp1.data.access_token}`;

  try {
    const instance = axios.create({
      withCredentials: true,
    });
    const url = "http://localhost:8000/api/is-onboard";
    const resp = await instance.get(url);
  } catch (error) {
    console.log(error);

    return {
      redirect: {
        permanent: false,
        destination: "/onboard",
      },
    };
  }
  return { props: {} };
}
