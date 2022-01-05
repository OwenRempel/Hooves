import { Link } from "react-router-dom"

function Nav() {
    return (
        <nav className='menu'>
            <Link to='/' >
                <div>
                    <span className="material-icons menuIcon">home</span>
                    <span>Home</span>
                </div>
            </Link>
            <Link to='/cows' >
                <div>
                    <span className="material-icons menuIcon">format_list_bulleted</span>
                    <span>List</span>
                </div>
            </Link>
            <Link to='/groups'>
                <div>
                    <span className="material-icons menuIcon">library_add</span>
                    <span>Groups</span>
                </div>
            </Link>
            <Link to='/feed' >
                <div>
                    <span className="material-icons menuIcon">grass</span>
                    <span>Feed</span>
                </div>
            </Link>
        </nav>
    )
}

export default Nav
