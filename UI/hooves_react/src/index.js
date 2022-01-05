import { render } from "react-dom";
import {
  BrowserRouter,
  Routes,
  Route
} from "react-router-dom";
import './css/index.css';
import App from "./App";
import Home from "./components/routes/Home";
//this is all the imports for the cows... so far
import CompAdd from "./components/routes/Companies/CompAdd";
import CowsList from "./components/routes/Cows/CowsList";
import CowsAdd from "./components/routes/Cows/CowsAdd";
import Cows from "./components/routes/Cows/Cows";
import Cow from "./components/routes/Cows/Cow";
//import settings
import Settings from "./components/routes/Settings/Settings";
import Profile from "./components/routes/Settings/Profile";
import AllSettings from "./components/routes/Settings/AllSettings";
import NotFound from "./components/routes/NotFound";
import Logout from "./components/Logout";



const rootElement = document.getElementById("root");
render(
  <BrowserRouter>
    <Routes>
      <Route path='/companies/add' element={<CompAdd/>}/>
      <Route path='/logout' element={<Logout/>}/>
      <Route path="/" element={<App />}>
        <Route index element={<Home />} />
        <Route path="cows" element={<Cows />} >
          <Route index element={<CowsList />} />
          <Route path="add" element={<CowsAdd/> } />
          <Route path=":id" element={<Cow/> } />
        </Route>
        <Route path='/settings' element={<Settings/>}>
        <Route index element={<AllSettings />} />
          <Route path='profile' element={<Profile/>}/>
        </Route>
        <Route path='*' element={<NotFound />} />
      </Route>
    </Routes>
  </BrowserRouter>,
  rootElement
);