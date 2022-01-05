import Search from './Search';
import { useState } from 'react';
import { Link } from 'react-router-dom';



function Header() {
    const [ProfileDrop, setProfileDrop] = useState(false)
    const handleClick = () => {
        setProfileDrop(!ProfileDrop)
    }
    const leaveClick = () =>{
        setProfileDrop(false);
    }
    return (
        <div className='header'>
            <h1 className='title'>Hooves</h1>
            <Search/>

            <div className='profileWrap'>
                <div className='profile' onClick={handleClick}>
                    <img src="/images/profile/Profile.jpg" alt='Profile' className='profileImg'/>
                </div>
                {ProfileDrop && 
                    <div className='userSettings'>
                            <Link to='/settings/profile' onClick={leaveClick}>Profile</Link>
                            <Link to='/settings' onClick={leaveClick}>Settings</Link>
                            <Link to='/logout' onClick={leaveClick}>Logout</Link>
                    </div>
                }
            </div>
        </div>
    );
  }
  
  export default Header