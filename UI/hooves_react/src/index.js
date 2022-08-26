import { render } from "react-dom";
import { BrowserRouter, Routes, Route } from "react-router-dom";
// global css
import './css/index.css';
//main app wrapper
import App from "./App";
//default page probably stats later
import Home from "./components/routes/Home";
import SearchPage from "./components/routes/SearchPage";
//routes for cows
import CompAdd from "./components/routes/Companies/CompAdd";
import CowsList from "./components/routes/Cows/CowsList";
import CowsAdd from "./components/routes/Cows/CowsAdd";
import Cows from "./components/routes/Cows/Cows";
import Cow from "./components/routes/Cows/Cow";
import CowUpdate from "./components/routes/Cows/CowUpdate";
import CowDelete from "./components/routes/Cows/CowDelete"

//imports for weights
import AddWeight from "./components/routes/Weights/AddWeight";
import EditWeight from "./components/routes/Weights/EditWeight";
import DeleteWeight from "./components/routes/Weights/DeleteWeight";
//import medical
import AddMedicine from "./components/routes/Medicines/AddMedicine";
import EditMedicine from "./components/routes/Medicines/EditMedicine";
import DeleteMedicine from "./components/routes/Medicines/DeleteMedicine";
//import settings
import Settings from "./components/routes/Settings/Settings";
import Profile from "./components/routes/Settings/Profile";
import AllSettings from "./components/routes/Settings/AllSettings";
import NotFound from "./components/routes/NotFound";
//imports for pens
import Pens from "./components/routes/Pens/Pens";
import PenDelete from "./components/routes/Pens/PenDelete";
import PenUpdate from "./components/routes/Pens/PenUpdate";
import PenOutlet from "./components/routes/Pens/PenOutlet";
//imports for groups
import GroupOutlet from "./components/routes/Group";
import GroupAdd from "./components/routes/Group/GroupAdd";
import GroupList from "./components/routes/Group/GroupList";
import GroupEdit from "./components/routes/Group/GroupEdit";
import GroupDelete from "./components/routes/Group/GroupDelete";
import GroupEntries from "./components/routes/Group/GroupEntries";
//logout component
import Logout from "./components/Logout";
import ViewItems from "./components/routes/Settings/ViewItems";



//TODO: Add routing for the groups and moving individual cows from pen to pen


const rootElement = document.getElementById("root");
render(
  <BrowserRouter>
    <Routes>
      <Route path='/companies/add' element={<CompAdd/>}/>
      <Route path='/logout' element={<Logout/>}/>
      <Route path="/" element={<App />}>
        <Route index element={<Home />} />
        <Route path="/search" element={<SearchPage/>}/>
        <Route path="cows" element={<Cows />} >
          <Route index element={<CowsList />} />
          <Route path=":ID" element={<Cow/> } />
          <Route path="add" element={<CowsAdd/> }/>
          <Route path="update">
            <Route index element={<CowsList />} />
            <Route path=":ID" element={<CowUpdate/>}/>
          </Route>
          <Route path="delete">
            <Route index element={<CowsList />} />
            <Route path=":ID" element={<CowDelete/>}/>
          </Route>
          <Route path="weight">
            <Route index element={<CowsList />} />
            <Route path="add/:ID" element={<AddWeight/>}/>
            <Route path="edit/:Cow/:ID" element={<EditWeight/>}/>
            <Route path="delete/:Cow/:ID" element={<DeleteWeight/>}/>
          </Route>
          <Route path="medical">
            <Route index element={<CowsList />} />
            <Route path="add/:ID" element={<AddMedicine/>}/>
            <Route path="edit/:Cow/:ID" element={<EditMedicine/>}/>
            <Route path="delete/:Cow/:ID" element={<DeleteMedicine/>}/>
          </Route>
        </Route>
        <Route path="groups" element={<GroupOutlet/>}>
          <Route index element={<GroupList/>}/>
          <Route path="add" element={<GroupAdd/>}/>  
          <Route path="edit/:ID" element={<GroupEdit/>}/>
          <Route path="delete/:ID" element={<GroupDelete/>}/>
          <Route path="entries/:ID" element={<GroupEntries/>}/>
        </Route>
        <Route path='/settings' element={<Settings/>}>
          <Route index element={<AllSettings />} />
          <Route path="view-items" element={<ViewItems/>}/>
          <Route path='profile' element={<Profile/>}/>
          <Route path="pens" element={<PenOutlet/>}>
            <Route index element={<Pens/>}/>
            <Route path="edit/:ID" element={<PenUpdate/>}/>
            <Route path="delete/:ID" element={<PenDelete/>}/>
          </Route>
        </Route>
        <Route path='*' element={<NotFound />} />
      </Route>
    </Routes>
  </BrowserRouter>,
  rootElement
);