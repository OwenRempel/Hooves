import Style from '../styles/header.module.css'
import Search from './Search';


function Header() {
    return (
        <div className={Style.header}>
            <h1 className={Style.title}>Hooves</h1>
            <Search/>

            <div className={Style.profileWrap}>
                <div className={Style.profile}>
                    <img src="/images/profile/Profile.jpg" className={Style.profileImg}/>
                </div>
            </div>
        </div>
    );
  }
  
  export default Header