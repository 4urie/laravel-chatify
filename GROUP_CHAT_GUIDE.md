# Group Chat Functionality Guide

## Overview
Your Laravel Chatify application now includes comprehensive Group Chat functionality with real-time messaging, member management, and multilingual support.

## Features Implemented

### ✅ Core Group Features
- **Create Groups** with name, description, and optional image
- **Real-time Group Messaging** with automatic polling
- **Member Management** (add/remove members)
- **Admin Controls** (rename group, manage members, delete group)
- **File Sharing** (images, documents up to 10MB)
- **Language Detection & Translation** for group messages

### ✅ User Roles
- **Creator**: Full control over the group (can't be removed, can delete group)
- **Admin**: Can add/remove members, edit group details
- **Member**: Can send messages and leave the group

### ✅ Database Structure
- `groups` table: Group information (name, description, image, creator)
- `group_members` table: User-group relationships with admin flags
- `group_messages` table: Group messages with file support and language detection

## How to Use

### 1. Navigation
- Use the navigation tabs in the sidebar to switch between "💬 Private Chats" and "👥 Groups"
- The active tab is highlighted in blue

### 2. Creating a Group
1. Go to the Groups section
2. Click "New Group" or "Create Your First Group"
3. Fill in the group details:
   - **Name** (required)
   - **Description** (optional)
   - **Image** (optional, up to 2MB)
   - **Members** (optional, select from available users)
4. Click "Create Group"

### 3. Group Chat Interface
- **Header**: Shows group name, member count, and language selector
- **Sidebar**: Group info, member list, and admin controls
- **Messages**: Real-time messaging with sender names and timestamps
- **File Sharing**: Click 📎 to attach images or documents

### 4. Member Management (Admins Only)
- **Add Members**: Click "+ Add" button in the sidebar
- **Remove Members**: Click "Remove" next to member names
- **View Member Roles**: Creator/Admin/Member badges are displayed

### 5. Group Administration
- **Edit Group**: Update name, description, or image
- **Delete Group**: Permanently delete the group (Creator only)
- **Leave Group**: Members can leave (Creator cannot leave)

### 6. Multilingual Support
- **Language Detection**: Automatic detection of message languages
- **Translation**: Click "Translate" button for foreign language messages
- **Language Preference**: Set your preferred language in the header dropdown

## API Endpoints

### Group Routes
```php
GET  /groups                           - List all groups
POST /groups                           - Create new group
GET  /groups/{group}                   - Show group chat
PUT  /groups/{group}                   - Update group details
DELETE /groups/{group}                 - Delete group

POST /groups/{group}/messages          - Send group message
GET  /groups/{group}/messages          - Get new messages (AJAX)

POST /groups/{group}/members           - Add member to group
DELETE /groups/{group}/members/{user}  - Remove member from group
POST /groups/{group}/leave             - Leave group

POST /groups/messages/{message}/translate - Translate group message
```

## Database Schema

### Groups Table
- `id` - Primary key
- `name` - Group name
- `description` - Group description (nullable)
- `image` - Group image path (nullable)
- `created_by` - Creator user ID
- `created_at`, `updated_at` - Timestamps

### Group Members Table
- `id` - Primary key
- `group_id` - Foreign key to groups
- `user_id` - Foreign key to users
- `is_admin` - Boolean admin flag
- `joined_at` - Join timestamp
- `created_at`, `updated_at` - Timestamps

### Group Messages Table
- `id` - Primary key
- `group_id` - Foreign key to groups
- `sender_id` - Foreign key to users
- `message` - Message content
- `message_type` - Type: text, image, file
- `file_path` - File path (nullable)
- `file_name` - Original filename (nullable)
- `detected_language` - Language code (nullable)
- `created_at`, `updated_at` - Timestamps

## File Storage
- Group images: `storage/app/public/group-images/`
- Group files: `storage/app/public/group-files/`
- Make sure to run `php artisan storage:link` for public access

## Real-time Features
- **Message Polling**: New messages are fetched every 2 seconds
- **Live Updates**: Messages appear instantly without page refresh
- **File Previews**: Images display inline, files show as downloadable links
- **Translation**: On-demand translation without page reload

## Security Features
- **Member Verification**: Only group members can send/receive messages
- **Admin Controls**: Member management restricted to admins
- **Creator Protection**: Group creator cannot be removed
- **File Validation**: File type and size restrictions
- **CSRF Protection**: All forms include CSRF tokens

## Sample Data
The system includes sample groups created by the seeder:
- **General Discussion**: Team announcements and discussions
- **Project Alpha**: Project-specific conversations
- **Random**: Casual conversations and fun topics

## Testing
1. Register/login with multiple users
2. Create a group with some members
3. Send messages in the group
4. Test file sharing functionality
5. Try translation features with different languages
6. Test admin functions (add/remove members, edit group)

## Troubleshooting

### Common Issues
1. **Groups not loading**: Check if migrations ran successfully
2. **Files not uploading**: Ensure `storage/app/public` is writable
3. **Translation not working**: Verify TranslationService configuration
4. **Real-time not working**: Check JavaScript console for errors

### Debug Commands
```bash
php artisan migrate:status    # Check migration status
php artisan storage:link      # Link storage directory
php artisan route:list        # List all routes
php artisan tinker           # Test models in console
```

## Future Enhancements
- Push notifications for new group messages
- Message read receipts for group messages
- Group message search functionality
- Group archive/mute options
- Bulk member operations
- Group templates and categories

---

Your group chat functionality is now fully operational! Users can create groups, chat in real-time, share files, and manage members with proper admin controls. 