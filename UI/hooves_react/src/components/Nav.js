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
            <Link to='/settings'>
                <div>
                    <span className="material-icons menuIcon">settings</span>
                    <span>Settings</span>
                </div>
            </Link>
            <Link to='/logout' >
                <div>
                    <span className="material-icons menuIcon">logout</span>
                    <span>Logout</span>
                </div>
            </Link>
        </nav>
    )
}

export default Nav
