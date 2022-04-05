import { useState } from "react";
import { Link } from "react-router-dom"

//TODO: Add Buttons for feedlot uses after that system is in place



function Nav() {
    const [ToggleClass, setToggleClass] = useState('menuSmall');
    const [Icon, setIcon] = useState('menu');
    const menuToggle = () =>{
       
            if(ToggleClass === 'menuSmall'){
                setToggleClass('menuBig');
                setIcon('arrow_back')
            }else{
                setToggleClass('menuSmall')
                setIcon('menu')
            }
      
       
    }

    const handelBlur = (e) => {
        if(!e.relatedTarget){
            setToggleClass('menuSmall')
            setIcon('menu')
        }
    }
    return (
        <nav className={`menu ${ToggleClass}`}>
            <button className='menuBackIcon btnClear' onBlur={handelBlur}>
                <i className="material-icons" id="menuic" onClick={menuToggle}>{Icon}</i>
            </button>
            <Link to='/' onClick={menuToggle}>
                <div >
                    <span className="material-icons menuIcon">home</span>
                    <span>Home</span>
                </div>
            </Link>
            <Link to='/cows' onClick={menuToggle}>
                <div>
                    <span className="material-icons menuIcon">format_list_bulleted</span>
                    <span>List</span>
                </div>
            </Link>
            <Link to='/groups' onClick={menuToggle}>
                <div>
                    <span className="material-icons menuIcon">library_add</span>
                    <span>Groups</span>
                </div>
            </Link>
            <Link to='/feed' onClick={menuToggle}>
                <div>
                    <span className="material-icons menuIcon">grass</span>
                    <span>Feed</span>
                </div>
            </Link>
        </nav>
    )
}

export default Nav
