function Profile() {
    let tokenExpire = localStorage.getItem('TokenExpire');
    let time = new Date(tokenExpire * 1000);
    
    return (
        <>
            <h2>
                {localStorage.getItem('User')}
            </h2>
            <h3>
                Auth Expire: {time.toLocaleString()} 
            </h3>
            <h3>
                User Auth Token: {localStorage.getItem('Token')}
            </h3>
        </>
    )
}

export default Profile
