import Search from './Search';


function Header() {
    return (
        <div className='header'>
            <h1 className='title'>Hooves</h1>
            <Search/>

            <div className='profileWrap'>
                <div className='profile'>
                    <img src="/images/profile/Profile.jpg" alt='Profile' className='profileImg'/>
                </div>
            </div>
        </div>
    );
  }
  
  export default Header